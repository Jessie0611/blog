<?php

declare(strict_types=1); //type declarations

function getUser(PDO $pdo, string $username): array|false
{
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
}
