<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/dbh.inc.php';

    $title = $_POST['title'];
    $content = $_POST['content'];
    $userID = $_SESSION['id'] ?? 1; // fallback if not logged in

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
        $stmt = $pdo->prepare("INSERT INTO posts (title, content, coverImage, userID, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$title, $content, $coverImageName, $userID]);

        header("Location: index.php?post=success");
        exit;
    } catch (PDOException $e) {
        die("Error inserting post: " . $e->getMessage());
    }
}

?>

<?php include 'header.php'; ?>



<section class="blogPostSection">
    <h1>FRESH GOSSIP 🍃</h1>

    <!-- Correct and single form -->
    <form id="blogPostForm" class="blogForm" action="addPost.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Post Title" required />
        <label for="postContent">
            <h4>Dearest Reader,</h4>
        </label>
        <textarea name="content" id="postContent" placeholder="It has come to this author’s attention …" rows="5" required></textarea>
        <h4>
        </h4>
        <input type="file" name="coverImage" accept="image/*" />

        <div class="formButtons">
            <button type="submit" name="submit">Publish</button>
            <button type="button" id="saveDraftBtn">Save Draft</button>
        </div>

        <p id="blogStatus"></p>
    </form>
</section>

<?php include 'footer.php'; ?>