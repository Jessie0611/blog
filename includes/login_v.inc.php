<?php

declare(strict_types=1);

function loginInputs()
{
    $loginUsername = $_SESSION["login_data"]["loginUsername"] ?? '';

    echo '<form action="includes/login.inc.php" method="POST" class="createAccountForm" novalidate>';
    echo '<input type="text" name="loginUsername" placeholder="Author Name" value="' . htmlspecialchars($loginUsername) . '">';
    echo '<input type="password" name="loginPassword" placeholder="Password">';
    echo '<br><button type="submit" name="login">Login</button> <br>';
    echo '<br></form><br>';

    unset($_SESSION["login_data"]);
}

function checkLoginErrors()
{
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];

        foreach ($errors as $error) {
            echo '<p class="form-error">' . $error . '</p>';
        }
        unset($_SESSION["errors_login"]);
    } else {
    }
}

function outputUsername()
{
    if (isset($_SESSION["user_id"])) {
        echo "You are logged in as " . htmlspecialchars($_SESSION["user_username"]);
    } else {
        echo "You are not logged in.";
    }
}
