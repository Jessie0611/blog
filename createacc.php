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

// Clear errors after displaying once
unset($_SESSION['errors_signup'], $_SESSION['signup_data']);
unset($_SESSION['errors_login'], $_SESSION['login_data']);
?>

<div class="create">

    <div style="flex: 1 1 350px; max-width: 400px;">
        <h1>CREATE ACCOUNT</h1>
        <?php signupInputs(); ?>
        <?php checkSignupErrors(); ?>


    </div>

    <div style="flex: 1 1 300px; max-width: 400px;">
        <h1>LOGIN</h1>


        <?php loginInputs(); ?>

        <?php checkLoginErrors(); ?>


    </div>

</div>

<?php include 'footer.php'; ?>