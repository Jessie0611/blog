<?php
require_once 'includes/config.php';
require_once 'includes/signup_v.inc.php';
require_once 'includes/login_v.inc.php';
include 'header.php';

// If already logged in, redirect to account page
if (isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

// Load form error messages & data if redirected
$signupErrors = $_SESSION['errors_signup'] ?? [];
$signupData = $_SESSION['signup_data'] ?? [];

$loginErrors = $_SESSION['errors_login'] ?? [];
$loginData = $_SESSION['login_data'] ?? [];
?>
<?php
// createacc.php — Combined Create Account + Sign-in page
if (session_status() === PHP_SESSION_NONE) session_start();

$reg_errors = [];
$login_errors = [];
$reg_success = false;

// Determine which form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'register') {
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $pwd      = $_POST['password'] ?? '';
        $pwd2     = $_POST['password2'] ?? '';

        if ($username === '') $reg_errors[] = 'Please provide a username.';
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $reg_errors[] = 'Please provide a valid email.';
        if ($pwd === '' || strlen($pwd) < 6) $reg_errors[] = 'Password must be at least 6 characters.';
        if ($pwd !== $pwd2) $reg_errors[] = 'Passwords do not match.';

        if (empty($reg_errors)) {
            // TODO: integrate with signup logic / database
            $reg_success = true;
            $_SESSION['created_user'] = htmlspecialchars($username);
        }
    } elseif ($action === 'login') {
        $email = trim($_POST['login_email'] ?? '');
        $pwd   = $_POST['login_password'] ?? '';

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $login_errors[] = 'Please enter a valid email.';
        if ($pwd === '') $login_errors[] = 'Please enter your password.';

        if (empty($login_errors)) {
            // TODO: replace with real auth check
            // Simulate login success for demonstration
            $_SESSION['user_email'] = $email;
            header('Location: index.php');
            exit;
        }
    }
}

?>

<main class="container" style="padding-top:18px">
    <div style="max-width:960px;margin:0 auto;padding:0 20px;">
        <div class="kicker" style="margin-bottom:10px">Account</div>

        <div class="card" style="padding:18px; display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">
            <section>
                <h2 style="margin-bottom:6px">Create an account</h2>
                <p class="lead" style="margin-bottom:12px">Join to comment, subscribe, and keep up with society notes.</p>

                <?php if ($reg_success): ?>
                    <div class="card" style="background:linear-gradient(180deg, rgba(246,230,240,0.4), rgba(255,248,243,0.4)); border-left:4px solid #C59D5F;">
                        <p><strong>Account created.</strong> Welcome, <?php echo $_SESSION['created_user']; ?>.</p>
                        <p><a href="index.php" class="btn">Return home</a></p>
                    </div>
                <?php else: ?>

                    <?php if (!empty($reg_errors)): ?>
                        <div style="margin-bottom:12px">
                            <?php foreach ($reg_errors as $e): ?>
                                <div class="card" style="background:#FFF5F9;border-left:4px solid rgba(197,157,95,0.6);padding:10px;margin-bottom:8px;color:#6b4f4f">
                                    <?php echo htmlspecialchars($e); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" novalidate style="display:flex;flex-direction:column;gap:12px">
                        <input type="hidden" name="action" value="register">

                        <label>
                            <div style="font-weight:700;margin-bottom:6px">Username</div>
                            <input name="username" class="input" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" placeholder="Your full name">
                        </label>

                        <label>
                            <div style="font-weight:700;margin-bottom:6px">Email</div>
                            <input name="email" class="input" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" placeholder="you@domain.com" type="email">
                        </label>

                        <div style="display:flex;gap:12px;flex-wrap:wrap">
                            <label style="flex:1 1 160px;">
                                <div style="font-weight:700;margin-bottom:6px">Password</div>
                                <input name="password" class="input" type="password" placeholder="••••••">
                            </label>

                            <label style="flex:1 1 160px;">
                                <div style="font-weight:700;margin-bottom:6px">Confirm</div>
                                <input name="password2" class="input" type="password" placeholder="Repeat password">
                            </label>
                        </div>

                        <div style="display:flex;gap:12px;align-items:center;margin-top:8px">
                            <button class="btn" type="submit">Create account</button>
                            <a href="index.php" class="btn secondary">Cancel</a>
                        </div>
                    </form>
                <?php endif; ?>
            </section>

            <aside>
                <div class="card" style="padding:16px;margin-bottom:16px;">
                    <h3 style="margin:0 0 8px">Already a member? Sign in</h3>

                    <?php if (!empty($login_errors)): ?>
                        <div style="margin-bottom:12px">
                            <?php foreach ($login_errors as $e): ?>
                                <div class="card" style="background:#FFF5F9;border-left:4px solid rgba(197,157,95,0.6);padding:10px;margin-bottom:8px;color:#6b4f4f">
                                    <?php echo htmlspecialchars($e); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" style="display:flex;flex-direction:column;gap:10px">
                        <input type="hidden" name="action" value="login">
                        <label>
                            <div style="font-weight:700;margin-bottom:6px">Email</div>
                            <input name="login_email" class="input" type="email" value="<?php echo htmlspecialchars($_POST['login_email'] ?? ''); ?>">
                        </label>

                        <label>
                            <div style="font-weight:700;margin-bottom:6px">Password</div>
                            <input name="login_password" class="input" type="password">
                        </label>

                        <div style="display:flex;gap:8px;align-items:center">
                            <button class="btn" type="submit">Sign in</button>
                            <a href="index.php" class="btn secondary">Back</a>
                        </div>
                    </form>
                </div>

                <div class="card" style="padding:12px;text-align:center;background:var(--accent-petal);">
                    <div style="font-weight:700">Privacy</div>
                    <p class="small" style="margin-top:8px">We only store the information required to operate your account.</p>
                </div>
            </aside>
        </div>
    </div>
</main>

<?php
if (file_exists('footer.php')) include 'footer.php';
?>