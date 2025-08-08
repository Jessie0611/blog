<?php
include 'includes/dbh.inc.php';
require_once 'includes/signup_v.inc.php';
require_once 'includes/login_v.inc.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

?>

<div class="account">
    <br>
    <h1>Hello, <?= htmlspecialchars($username) ?>!</h1>
    <h4>Welcome to your account page. You’re now sipping The Tea in style.</h4>
    <br>
</div>

<?php include 'footer.php'; ?>