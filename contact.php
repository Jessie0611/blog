<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();

    // Optional: redirect or show confirmation
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Tea</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="content">
        <div class="header">
            <img class="heroImg" src="images/theTT.png" alt="heroImg"> <br>
            <nav class="navLinks">
                <a href="index.html">DASHBOARD</a>
                <a href="addPost.html">SPILL TEA</a>
                <a href="account.html">ACCOUNT</a>
                <a href="contact.html">CONTACT US</a>
            </nav>
        </div>
        <div class="contact">
            <h1>CONTACT US</h1>
            <h4>Have a tip? A scandal? A misplaced parasol? Write to The Tea — your secret is safe with us (unless it’s
                juicy).</h4>
            <form id="contactForm" class="contactForm" method="POST" action="contact.php">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="message" placeholder="Message" rows="2" required></textarea>
                <div class="formButtons">
                    <button type="submit">SEND</button>
                </div>
                <p id="form-status"></p>
            </form>
        </div>


        <footer class="footer">
            <h3>&copy; &nbsp; 2025 The Tea &nbsp;&nbsp;|&nbsp;&nbsp; All gossip served hot &nbsp; ☕ </h3>
        </footer>
        <script src="script.js"></script>
    </div>
</body>

</html>