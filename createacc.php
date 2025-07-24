<?php
include 'database.php';

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['createAccount'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $displayName = trim($_POST['displayName']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (!$username || !$email || !$displayName || !$password || !$confirmPassword) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT userID FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Username or email is already taken.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, displayName, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $username, $hashedPassword, $email, $displayName);
            if ($stmt->execute()) {
                $success = true;
            } else {
                $errors[] = "Error creating account. Please try again.";
            }
        }
        $stmt->close();
    }
}

$loginErrors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $loginUsername = trim($_POST['loginUsername']);
    $loginPassword = $_POST['loginPassword'];

    if (!$loginUsername || !$loginPassword) {
        $loginErrors[] = "Please enter username and password.";
    } else {
        $stmt = $conn->prepare("SELECT userID, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $loginUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($loginPassword, $user['password'])) {
                session_start();
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['username'] = $loginUsername;
                header("Location: index.php");
                exit();
            } else {
                $loginErrors[] = "Incorrect password.";
            }
        } else {
            $loginErrors[] = "Username not found.";
        }
        $stmt->close();
    }
}
?>

<?php include 'header.php'; ?>

<div class="create">

    <div style="flex: 1 1 350px; max-width: 400px;">
        <h1>CREATE ACCOUNT</h1>

        <?php if ($success): ?>
            <p class="success">Account created successfully! You can now log in.</p>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="errors" style="background:#fdd; color:#900; padding:0.5rem; border-radius:4px; margin-bottom:1rem;">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="createacc.php" method="POST" class="createAccountForm" novalidate>
                <input type="text" name="username" placeholder="Username" required value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" />
                <input type="text" name="displayName" placeholder="Display/Author Name" required value="<?= isset($displayName) ? htmlspecialchars($displayName) : '' ?>" />
                <input type="email" name="email" placeholder="Email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" />
                <input type="password" name="password" placeholder="Password" required />
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required />
                <br><button type="submit" name="createAccount">Create Account</button><br>
            </form>
        <?php endif; ?>
    </div>

    <div style="flex: 1 1 300px; max-width: 400px;">
        <h1>LOGIN</h1>

        <?php if (!empty($loginErrors)): ?>
            <div class="errors" style="background:#fdd; color:#900; padding:0.5rem; border-radius:4px; margin-bottom:1rem;">
                <ul>
                    <?php foreach ($loginErrors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="createacc.php" method="POST" class="createAccountForm" novalidate>
            <input type="text" name="loginUsername" placeholder="Username" required value="<?= isset($loginUsername) ? htmlspecialchars($loginUsername) : '' ?>" />
            <input type="password" name="loginPassword" placeholder="Password" required />
            <br><button type="submit" name="login">Login</button><br>
        </form>
    </div>

</div>

<?php include 'footer.php'; ?>