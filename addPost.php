<?php
$userID = $_SESSION['userID'] ?? 1; // fallback to 1 if not logged in (for testing)

// Fetch display name from database
$displayName = '';
if ($stmt = $conn->prepare("SELECT displayName FROM users WHERE userID = ?")) {
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($displayName);
    $stmt->fetch();
    $stmt->close();
}
?>


<?php include 'header.php'; ?>



<section class="blogPostSection">
    <h1>FRESH GOSSIP 🍃</h1>

    <!-- Correct and single form -->
    <form id="blogPostForm" class="blogForm" action="addPost.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Post Title" required />
        <h4>
            <b>Author Name :</b> <?php echo htmlspecialchars($displayName); ?>
        </h4>

        <label for="postContent">
            <h4>Dearest Reader,</h4>
        </label>
        <textarea name="content" id="postContent" placeholder="It has come to this author’s attention …" rows="5" required></textarea>
        <h4>
            <b>Author Name :</b> <?php echo htmlspecialchars($displayName); ?>
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