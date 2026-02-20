<!-- header.php -->
<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Tea</title>
    <link rel="stylesheet" href="bridgerton.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,700&family=Quicksand:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/dashboard/blog/bridgerton.css">

</head>

<body>
    <header class="site-header">
        <div class="header-inner">
            <div class="brand">
                <div class="logo">B</div>
                <div>
                    <h1>Bridgerton Blog</h1>
                    <div class="lead">Gossamer stories & genteel musings</div>
                </div>
            </div>

            <nav class="site-nav">
                <a href="index.php">Home</a>
                <a href="addPost.php">Posts</a>
                <a href="contact.php">Contact</a>
                <a href="account.php" class="button">Account</a>
            </nav>
        </div>
    </header>