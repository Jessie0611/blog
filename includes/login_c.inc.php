<?php

declare(strict_types=1); //type declarations

function isEmpty(string $username, string $pwd)
{
    if (empty($username) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}
function isUsernameIncorrect(bool|array $results): bool
{
    return !$results;
}

function isPwdIncorrect(string $pwd, string $hashedPwd): bool
{
    return !password_verify($pwd, $hashedPwd);
}
