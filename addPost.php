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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Tea</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="content">
        <div class="header">
            <img class="heroImg" src="images/theTT.png" alt="heroImg" />
            <br />
            <nav class="navLinks">
                <a href="index.php">DASHBOARD</a>
                <a href="addPost.php">SPILL TEA</a>
                <a href="account.php">ACCOUNT</a>
                <a href="contact.php">CONTACT US</a>
            </nav>
        </div>

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

        <footer class="footer">
            <h3>&copy; 2025 The Tea &nbsp;&nbsp;|&nbsp;&nbsp; All gossip served hot ☕</h3>
        </footer>

        <script src="script.js"></script>
    </div>
</body>

</html>