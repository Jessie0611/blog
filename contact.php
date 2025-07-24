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

<?php include 'header.php'; ?>


<div class="contact">
    <h1>CONTACT US</h1>
    <h4>Have a tip? A scandal? A misplaced parasol? Write to The Tea — your secret is safe with us (unless it’s
        juicy).</h4>
    <?php if (!empty($success)): ?>
        <p class="success">
        <h3>Thank you for your message! <i>The Tea</i> will sip it shortly. &nbsp; ☕ </h3>
        </p>
    <?php endif; ?>

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


<?php include 'footer.php'; ?>