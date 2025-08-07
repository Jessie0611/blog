<?php //handles data, database interaction, business logic

declare(strict_types=1); //type declarations


function getUsername(object $pdo, string $username)
{
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query); //prevent sql injection
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch as associative array
    return $result;
}
function getEmail(object $pdo, string $email)
{
    $query = "SELECT email FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query); //prevent sql injection
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch first result from associative array
    return $result;
}

function setUser(object $pdo, string $pwd, string $username, string $email)

{
    $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email)";
    $stmt = $pdo->prepare($query); //prevent sql injection

    $options = [
        'cost' => 12
    ];
    $hasHedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hasHedPwd);
    $stmt->bindParam(":email", $email);

    $stmt->execute();
}
