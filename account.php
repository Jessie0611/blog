<?php
require_once 'includes/config.php'; // Ensure session is started
include 'includes/dbh.inc.php';
include 'header.php';

// Redirect to login/create page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: createacc.php");
    exit();
}
// fetch full user record
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(":id", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get user info from session
$username = $_SESSION['user_username'] ?? 'Guest';

?>
<form action="includes/logout.inc.php" method="POST">
    <button type="submit" name="logout">Logout</button>
</form>

<div class="account">
    <br>
    <h1>Hello, <?= htmlspecialchars($username) ?>!</h1>
    <h4>Welcome to your account page. You’re now sipping The Tea in style.</h4>
    <br>
</div>

<?php include 'footer.php'; ?>