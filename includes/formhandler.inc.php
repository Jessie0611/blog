<?php //handles a user registration form submission and safely stores the new user's data (hashed password) in a database.
if ($_SERVER["REQUEST_METHOD"] == "POST") { //Only runs the registration logic if the form was submitted using POST
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        require_once "dbh.inc.php";
        $query = "INSERT INTO users (username, pwd, email) VALUES ( ?, ?, ?);";

        $stmt = $pdo->prepare($query);  //Uses parameterized queries to prevent SQL injection
        $options = [
            'cost' => 12
        ];
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $hashedPwd);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $pdo = null; //close connection to db
        $stmt = null;
        header("Loocation: index.php");

        die();
    } catch (PDOException $e) {

        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
