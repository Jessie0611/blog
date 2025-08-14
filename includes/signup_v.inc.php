<?php //Displays data, user interface (HTML/CSS/JS)

declare(strict_types=1);

function signupInputs()
{
    echo '<form action="includes/signup.inc.php" method="POST" class="createAccountForm" novalidate>';

    $username = $_SESSION["signup_data"]["username"] ?? '';
    $email = $_SESSION["signup_data"]["email"] ?? '';

    $usernameTaken = isset($_SESSION["errors_signup"]["username_taken"]);
    $emailUsed = isset($_SESSION["errors_signup"]["email_used"]);
    $invalidEmail = isset($_SESSION["errors_signup"]["invalid_email"]);

    echo '<input type="text" name="username" placeholder="Author Name" value="' . (!$usernameTaken ? htmlspecialchars($username) : '') . '">';
    echo '<input type="password" name="pwd" placeholder="Password">';
    echo '<input type="text" name="email" placeholder="E-Mail" value="' . (!$emailUsed && !$invalidEmail ? htmlspecialchars($email) : '') . '">';

    echo '<button type="submit" name="createAccount">Create Account</button>';
    echo '</form>';

    unset($_SESSION['signup_data']);
}



function checkSignupErrors()
{
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        foreach ($errors as $error) {
            echo '<p class="formError">' . htmlspecialchars($error) . '</p>';
        }

        //Clear only after displaying
        unset($_SESSION['errors_signup']);
    } elseif (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo '<br><p class="formSuccess">Signup Successful! Please login.</p>';
    }
}
