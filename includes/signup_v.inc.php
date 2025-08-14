<?php //Displays data, user interface (HTML/CSS/JS)

declare(strict_types=1);

function signupInputs()
{
    echo '<form action="includes/signup.inc.php" method="POST" class="createAccountForm" novalidate>';

    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" name="username" class="createAccountForm" placeholder="Author Name" value="' . $_SESSION["signup_data"]["username"] . '"><br>';
    } else {
        echo '<input type="text" name="username" class="createAccountForm" placeholder="Author Name"> ';
    }
    echo ' <input type="password" name="pwd" class="createAccountForm" placeholder="Password">';

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo '<input type="text" name="email" class="createAccountForm" placeholder="E-Mail" value="' . $_SESSION["signup_data"]["email"] . '"><br>';
    } else {
        echo '<input type="text" name="email" class="createAccountForm" placeholder="E-Mail">';
    }

    echo '<br><button type="submit" name="createAccount">Create Account</button> <br>';
}

function checkSignupErrors()
{
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        foreach ($errors as $error) {
            echo '<p class ="formError">' . $error . '</p>';
        }

        unset($_SESSION['errors_signup']);
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo '<br>';
        echo '<p class="formSuccess"> Signup Successful! Please login. </p>';
    }
}
