<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["loginUsername"] ?? '';
    $pwd = $_POST["loginPassword"] ?? '';


    try {
        require_once 'dbh.inc.php';     // DB connection
        require_once 'login_m.inc.php'; // Model
        require_once 'login_c.inc.php'; // Controller
        require_once 'config.php';      // Session start

        $errors = [];
        // Input validation
        if (isEmpty($username, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        } else {
            $result = getUser($pdo, $username);

            // If no user found
            if (!$result || isUsernameIncorrect($result)) {
                $errors["login_incorrect"] = "Incorrect login information!";
            }
            // If password is wrong
            elseif (isPwdIncorrect($pwd, $result["pwd"])) {
                $errors["login_incorrect"] = "Incorrect login information!";
            }
        }

        // Handle login failure
        if (!empty($errors)) {
            $_SESSION["errors_login"] = $errors;
            $_SESSION["login_data"]["loginUsername"] = $username;
            header("Location: ../createacc.php");
            exit();
        }

        // Successful login: regenerate session
        $newSessionID = session_create_id();
        session_id($newSessionID . $result["id"]);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = $result["username"];
        $_SESSION['last_regeneration'] = time();

        header("Location: ../account.php");
        exit();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../createacc.php");
    exit();
}
