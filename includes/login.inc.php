<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        require_once 'dbh.inc.php'; //database connection -- this order of  require_once does matter
        require_once 'login_m.inc.php'; //model
        require_once 'login_c.inc.php'; // control
        //error handlers
        $errors = [];

        if (isEmpty($username, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        $result = getUser($pdo, $username);

        if (isUsernameIncorrect($results)) {
            $errors["login_incorrect"] = "Incorrect username!";
        }
        if (!sUsernameIncorrect($result) && isPwdIncorrect($pwd, $result["pwd"])) {
            $errors["login_incorrect"] = "Incorrect Login Information!";
        }
        require_once 'config.php';

        if ($errors) {
            $_SESSION["errors_login"] = $errors;

            header("Location: ../index.php");
            die();
        }

        $newSessionID = session_create_id();
        $sessionID = $newSessionID . "" . $result["id"];
        session_id($sessionID);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION['last_regeneration'] = time();
        header("Location: ../index.php?login=success");
        $pdo = null;
        $statement = null;
        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
