<?php

declare(strict_types=1); //type declarations

function isEmpty(string $username, string $pwd)
{
    return empty($username) || empty($pwd);
}
function isUsernameIncorrect(bool|array $results): bool
{
    return !$results;
}

function isPwdIncorrect(string $pwd, string $hashedPwd): bool
{
    return !password_verify($pwd, $hashedPwd);
}
