<?php
require_once 'includes/config.php'; // Ensure session is started
include 'includes/dbh.inc.php';
include 'header.php';

// Check if post ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid post ID.</p>";
    include 'footer.php';
    exit();
}

$postID = (int)$_GET['id'];

// Fetch the post from the database
$stmt = $pdo->prepare("SELECT * FROM posts WHERE postID = :postID AND status = 'published'");
$stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "<p>Sorry, the post could not be found or isn't published.</p>";
    include 'footer.php';
    exit();
}
?>

<section class="viewPost">
    <div class="Vpost">

        <h1><?= htmlspecialchars($post['title']) ?></h1>

        <?php if (!empty($post['coverImage'])): ?>
            <img src="uploads/<?= htmlspecialchars($post['coverImage']) ?>" alt="Cover Image" style="width: 70%; object-fit: cover; margin-bottom: 1rem;">
        <?php endif; ?>

        <p style="color: #888; font-size: 0.9rem;">
            Published on <?= date('F j, Y, g:i a', strtotime($post['created_at'])) ?>
        </p>

        <div class="post-content" style="line-height: 1.6; font-size: 1.1rem;">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>

        <a href="index.php" style="display: inline-block; margin-top: 2rem; text-decoration: none; color: #A09CC2; font-size:large;">← Back to Home</a>
</section>
</div>

<?php include 'footer.php'; ?>