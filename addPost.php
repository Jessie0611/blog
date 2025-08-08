<?php
require_once 'includes/dbh.inc.php'; // ✅ Add this to define $pdo

$userID = $_SESSION['id'] ?? 1; // fallback to 1 if not logged in (for testing)

$username = '';

$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$userID]);
$row = $stmt->fetch();

if ($row) {
    $username = $row['username'];
}
?>


<?php include 'header.php'; ?>



<section class="blogPostSection">
    <h1>FRESH GOSSIP 🍃</h1>

    <!-- Correct and single form -->
    <form id="blogPostForm" class="blogForm" action="addPost.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Post Title" required />
        <h4>
            <b>Author Name :</b> <?php echo htmlspecialchars($username); ?>
        </h4>

        <label for="postContent">
            <h4>Dearest Reader,</h4>
        </label>
        <textarea name="content" id="postContent" placeholder="It has come to this author’s attention …" rows="5" required></textarea>
        <h4>
            <b>Author Name :</b> <?php echo htmlspecialchars($username); ?>
        </h4>
        <input type="file" name="coverImage" accept="image/*" />

        <div class="formButtons">
            <button type="submit" name="submit">PUBLISH</button>
            <button type="button" id="saveDraftBtn">SAVE DRAFT</button>
        </div>

        <p id="blogStatus"></p>
    </form>
</section>

<?php include 'footer.php'; ?>