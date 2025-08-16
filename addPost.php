<?php
require_once 'includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['id'] ?? 1;
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = $_POST['status'] ?? 'published';


    //load any recent drafts
    $draft = null;
    try {
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE userID = ? AND status = 'draft' ORDER BY updated_at DESC LIMIT 1");
        $stmt->execute([$userID]);
        $draft = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error inserting post: " . $e->getMessage());
    }
    // Handle file upload
    $coverImageName = '';
    if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $coverImageName = basename($_FILES['coverImage']['name']);
        $uploadPath = $uploadDir . $coverImageName;

        if (!move_uploaded_file($_FILES['coverImage']['tmp_name'], $uploadPath)) {
            die("Failed to upload image.");
        }
    }

    // Insert post
    try {
        $stmt = $pdo->prepare("INSERT INTO posts (userID, title, content, coverImage, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$userID, $title, $content, $coverImageName, $status]);
        // Redirect to index with correct status
        header("Location: addPost.php?post=" . $status);
        exit;
    } catch (PDOException $e) {
        die("Error inserting post: " . $e->getMessage());
    }
}
?>

<?php include 'header.php'; ?>


<section class="blogPostSection">
    <?php

    // Show feedback
    if (isset($_GET['post'])) {
        if ($_GET['post'] === 'published') {
            echo "<p class='success'>Post published successfully!</p>";
        } elseif ($_GET['post'] === 'draft') {
            echo "<p class='info'>Draft saved successfully!</p>";
        }
    }
    ?>

    <h1>FRESH GOSSIP 🍃</h1>
    <form id="blogPostForm" class="blogForm" action="addPost.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" id="postTitle" placeholder="Post Title" required />

        <label for="postContent">
            <h4>Dearest Reader,</h4>
        </label>
        <textarea name="content" id="postContent" placeholder="It has come to this author’s attention …" rows="5" required></textarea>

        <input type="file" name="coverImage" accept="image/*" />

        <!-- Hidden field to control post status -->
        <input type="hidden" name="status" id="postStatus" value="published" />
        <p id="blogStatus"></p>

        <div class="formButtons">
            <button type="submit" name="submit">Publish</button>
            <button type="button" id="saveDraftBtn">Save Draft</button>
            <button type="button" id="clearDraftBtn">Clear Draft</button>

        </div>

    </form>

    <script>
        document.getElementById('saveDraftBtn').addEventListener('click', function() {
            document.getElementById('postStatus').value = 'draft';
            document.getElementById('blogPostForm').submit();
        });
    </script>
</section>


<?php include 'footer.php'; ?>