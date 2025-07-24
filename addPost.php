<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    // Handle file upload
    $imageName = '';
    if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === 0) {
        $imageName = basename($_FILES['coverImage']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;

        move_uploaded_file($_FILES['coverImage']['tmp_name'], $targetFile);
    }

    $stmt = $conn->prepare("INSERT INTO posts (userID, title, content, coverImage) VALUES (?, ?, ?, ?)");
    $userID = 1; // You can replace this with $_SESSION['userID'] when user login is added
    $stmt->bind_param("isss", $userID, $title, $content, $imageName);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
?>

<?php include 'header.php'; ?>



<section class="blogPostSection">
    <h1>FRESH GOSSIP 🍃</h1>

    <!-- Correct and single form -->
    <form id="blogPostForm" class="blogForm" action="addPost.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Post Title" required />
        <input type="text" name="author" placeholder="Author Name" />

        <label for="postContent">
            <h4>Dearest Reader,</h4>
        </label>
        <textarea name="content" id="postContent" placeholder="It has come to this author’s attention …" rows="5" required></textarea>

        <input type="file" name="coverImage" accept="image/*" />

        <div class="formButtons">
            <button type="submit" name="submit">PUBLISH</button>
            <button type="button" id="saveDraftBtn">SAVE DRAFT</button>
        </div>

        <p id="blogStatus"></p>
    </form>
</section>

<?php include 'footer.php'; ?>