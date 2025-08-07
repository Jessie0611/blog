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

function isUsernameIncorrect(bool|array $results) //if either bool or array we want to accept the results
{
    if (!$results) {
        return true;
    } else {
        return false;
    }
}
function isPwdIncorrect(string $pwd, string $hashedPwd) //if either bool or array we want to accept the results
{
    if (password_verify($pwd, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}
