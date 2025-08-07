<?php //Processes user input, communicates with Model & View

declare(strict_types=1);

function isEmpty(string $username, string $pwd, string $email)
{
    if (empty($username) || empty($pwd) || empty($email)) {
        return true;
    } else {
        return false;
    }
}

function isValidE(string $email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function usernameTaken(object $pdo, string $username)
{
    if (getUsername($pdo, $username)) {
        return true;
    } else {
        return false;
    }
}
function isEmailRegistered(object $pdo, string $email)
{
    if (getEmail($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function createUser(object $pdo, string $pwd, string $username, string $email)
{
    setUser($pdo, $pwd, $username, $email);
}
