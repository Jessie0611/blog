<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        require_once 'dbh.inc.php';
        require_once 'signup_m.inc.php';
        require_once 'signup_c.inc.php';
        require_once 'config.php';

        $errors = [];

        if (isEmpty($username, $pwd, $email)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (isValidE($email)) {
            $errors["invalid_email"] = "Please enter a valid E-Mail!";
        }
        if (usernameTaken($pdo, $username)) {
            $errors["username_taken"] = "This username is already taken!";
        }
        if (isEmailRegistered($pdo, $email)) {
            $errors["email_used"] = "E-Mail already registered!";
        }

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            $_SESSION["signup_data"] = [
                "username" => $username,
                "email" => $email
            ];
            header("Location: ../createacc.php");
            die();
        }

        //use your controller logic
        createUser($pdo, $pwd, $username, $email);

        //Redirect on success
        header("Location: ../createacc.php?signup=success");
        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../createacc.php");
    die();
}
