<?php
require_once 'includes/config.php';
require_once 'includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postID']) && is_numeric($_POST['postID'])) {
    $postID = (int)$_POST['postID'];
    $userID = $_SESSION['user_id'] ?? null;

    if (!$userID) {
        header("Location: account.php");
        exit();
    }

    // Ensure user owns the post
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE postID = :postID AND userID = :userID");
    $stmt->execute([':postID' => $postID, ':userID' => $userID]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        die("Post not found or access denied.");
    }

    // Optionally: delete cover image file from uploads/
    if (!empty($post['coverImage'])) {
        $imagePath = 'uploads/' . $post['coverImage'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // delete image
        }
    }

    // Delete post
    $deleteStmt = $pdo->prepare("DELETE FROM posts WHERE postID = :postID AND userID = :userID");
    $deleteStmt->execute([':postID' => $postID, ':userID' => $userID]);

    // Redirect back to account page
    header("Location: account.php?deleted=1");
    exit();
} else {
    die("Invalid request.");
}
