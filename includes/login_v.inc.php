<?php

declare(strict_types=1);

function loginInputs()
{
    $loginUsername = $_SESSION["login_data"]["loginUsername"] ?? '';

    echo '<form action="includes/login.inc.php" method="POST" class="createAccountForm" novalidate>';

    echo '<input type="text" name="loginUsername" placeholder="Username" required value="' . htmlspecialchars($loginUsername) . '"> <br>';

    echo '<input type="password" name="loginPassword" placeholder="Password" required><br>';

    echo '<br><button type="submit" name="login">Login</button><br>';
    echo '</form>';
}

function outputUsername()
{
    if (isset($_SESSION["user_id"])) {
        echo "You are logged in as " . htmlspecialchars($_SESSION["user_username"]);
    } else {
        echo "You are not logged in.";
    }
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
