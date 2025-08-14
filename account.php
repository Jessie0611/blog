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

<div class="account" style="display: flex; align-items: center; justify-content: space-between; max-width: 700px; margin: 2rem auto; padding: 1rem; border: 1px solid #ddd; border-radius: 8px;">

    <div>
        <h1>Hello, <?= htmlspecialchars($username) ?>!</h1>
        <h4>Welcome to your account page. You’re now sipping The Tea in style.</h4>
    </div>

    <form action="includes/logout.inc.php" method="POST" style="margin: 0;">
        <button type="submit" name="logout" style="padding: 0.4rem 0.8rem; background-color: #A09CC2; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Logout
        </button>
    </form>

</div>


<?php include 'footer.php'; ?>