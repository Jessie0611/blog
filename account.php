<?php
session_start(); // Start the session

// Redirect if not logged in
if (!isset($_SESSION['userID'])) {
    header("Location: createacc.php");
    exit();
}

// Assume $pdo is your PDO connection, created earlier
$userID = $_SESSION['userID'];

try {
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
    $stmt->execute(['id' => $userID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = $user['username'];
    } else {
        // User not found — fallback or handle error
        $username = "Guest";
    }
} catch (PDOException $e) {
    // Handle query error gracefully
    $username = "Guest";
    // Optionally log $e->getMessage() somewhere
}
?>

<?php include 'header.php'; ?>

<div class="account">
    <br>
    <h1>Hello, <?= htmlspecialchars($username) ?>!</h1>
    <h4>Welcome to your account page. You’re now sipping The Tea in style.</h4>
    <br>
</div>

<?php include 'footer.php'; ?>