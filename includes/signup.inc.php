<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        require_once 'dbh.inc.php'; //database connection
        require_once 'signup_m.inc.php'; //model
        require_once 'signup_c.inc.php'; //control

        //error handlers
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

        require_once 'config.php';

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            //the below code will keep the data input by the user if errors exist so they do not have to retype:
            $signupData = [
                "username" => $username,
                "email" => $email
            ];
            $_SESSION["signup_data"] = $signupData;

            header("Location: ../index.php");
            die();
        }

        createUser($pdo, $pwd, $username, $email);
        header("Location: ../index.php?signup=success");

        $pdo = null;
        $stmt = null;

        $query = "INSERT INTO users (username, pwd, email) VALUES ( ?, ?, ?);";

        $stmt = $pdo->prepare($query);
        $options = [
            'cost' => 12
        ];
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $hashedPwd);
        $stmt->bindParam(":email", $email);
        $stmt->execute([$username, $pwd, $email]);
        $pdo = null;
        $stmt = null;
        header("Location: ../index.php");

        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
