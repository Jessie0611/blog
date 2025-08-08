<?php
require_once 'includes/dbh.inc.php';

$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    try {
        $stmt = $pdo->prepare("
          INSERT INTO contact_messages (name, email, message, submitted_at)
          VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$name, $email, $message]);

        $success = true;
    } catch (PDOException $e) {
        die("Failed to submit contact form: " . $e->getMessage());
    }
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