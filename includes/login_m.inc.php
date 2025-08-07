<?php

declare(strict_types=1); //type declarations

function getUser(object $pdo, string $username)
{
    $query = "SELECT * FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query); //prevent sql injection
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetch as associative array
    return $result;
}
