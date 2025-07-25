<?php
session_start();
include 'database.php';

// Redirect if not logged in
if (!isset($_SESSION['userID'])) {
    header("Location: createacc.php");
    exit();
}

// Get user's display name from database
$userID = $_SESSION['userID'];
$stmt = $conn->prepare("SELECT displayName FROM users WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$displayName = $user['displayName'];
$stmt->close();
?>

<?php include 'header.php'; ?>

<div class="account">
    <br>
    <h1>Hello, <?= htmlspecialchars($displayName) ?>!</h1>
    <h4>Welcome to your account page. You’re now sipping The Tea in style.</h4>
    <br>
</div>


<?php include 'footer.php'; ?>