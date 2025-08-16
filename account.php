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

// Fetch posts created by the logged-in user, order by latest first
$stmtPosts = $pdo->prepare("SELECT * FROM posts WHERE userID = :userID AND status = 'published' ORDER BY created_at DESC");
$stmtPosts->bindParam(':userID', $_SESSION['user_id'], PDO::PARAM_INT);
$stmtPosts->execute();
$userPosts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="account">
    <form action="includes/logout.inc.php" class="createAccountForm" method="POST" style="margin: 0;">
        <button type="submit" name="logout" style="padding: 0.4rem 0.8rem; background-color: #A09CC2; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Logout
        </button>
        <h1>Hello, <?= htmlspecialchars($username) ?>!</h1>
        <h4>Welcome to your account page. You’re now sipping The Tea in style.</h4>

        <h2>Your Posts</h2>
        <?php if (empty($userPosts)) : ?>
            <p>You haven’t posted anything yet. Time to spill some tea!</p>
        <?php else: ?>
            <div class="user-posts">
                <?php foreach ($userPosts as $userPost): ?>
                    <div class="post-summary">
                        <h3><?= htmlspecialchars($userPost['title']) ?></h3>
                        <?php if (!empty($userPost['coverImage'])): ?>
                            <img src="uploads/<?= htmlspecialchars($userPost['coverImage']) ?>" alt="Cover Image" style="max-width: 30%; object-fit: cover;">
                        <?php endif; ?>
                        <p><?= nl2br(htmlspecialchars(substr($userPost['content'], 0, 200))) ?>...</p>
                        <small>Posted on <?= date('F j, Y, g:i a', strtotime($userPost['created_at'])) ?></small>
                        <br>
                        <a href="viewPost.php?id=<?= $userPost['postID'] ?>">
                            <div class="readMore"> Read More</div>
                        </a>
                        <br>
                        <!-- 🗑️ Delete form -->
                        <form action="deletePost.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');" style="margin-top: 0.5rem;">
                            <input type="hidden" name="postID" value="<?= $userPost['postID'] ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </div>
            </div>
        <?php endforeach; ?>
</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
    <p style="color: green;">Post deleted successfully.</p>
<?php endif; ?>



</h4>
</div>


</form>

</div>


<?php include 'footer.php'; ?>