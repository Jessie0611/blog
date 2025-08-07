<!-- header.php -->
<?php
session_start();
include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Tea</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="content">
        <div class="header">
            <img class="heroImg" src="images/theTT.png" alt="heroImg"> <br>
            <nav class="navLinks">
                <a href="index.php">DASHBOARD</a>
                <a href="contact.php">CONTACT</a>
                <a href="addPost.php">SPILL TEA</a>
                <a href="account.php">ACCOUNT</a>
            </nav>
        </div>