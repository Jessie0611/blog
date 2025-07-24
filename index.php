<?php
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
                <a href="index.html">DASHBOARD</a>
                <a href="addPost.html">SPILL TEA</a>
                <a href="account.html">ACCOUNT</a>
                <a href="contact.html">CONTACT US</a>
            </nav>
        </div>
        <div class="row">
            <div class="leftColumn">
                <div class="post">
                    <!-- Dynamic posts from database -->
                    <?php
                    $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5");
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='post'>";
                        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                        if (!empty($row['coverImage'])) {
                            echo "<img src='uploads/" . htmlspecialchars($row['coverImage']) . "' alt='Post Cover' style='width:100%; max-height:300px; object-fit:cover;'>";
                        }
                        echo "<p>" . nl2br(substr(htmlspecialchars($row['content']), 0, 300)) . "...</p>";
                        echo "<a href='viewPost.php?id=" . $row['postID'] . "' class='readMore'>Read More</a>";
                        echo "</div>";
                    }
                    ?>

                </div>
            </div>

            <div class="rightColumn">
                <div class="post">
                    <h1>HOTTEST TEA🔥</h1>
                    <img src="images/carriage.jpg" alt="" width="80%">
                    <p><b>Whispers in the Wisteria: <br>A Carriage Ride Causes Quite the Commotion</b> <br>
                        It seems the delicate calm of yesterday's afternoon was shattered—not by thunder, but by
                        thundering hooves. What was meant to be a scenic carriage ride through the flowering
                        wisteria-lined lanes has quickly become the most whispered-about event of the week...
                    </p>
                    <hr>
                    <img src="images/roset.jpeg" width="75%">

                    <p><b>Roses, Ribbons, and Reckless Rides: <br> Lady Ashcombe Spills the Tea</b> <br>
                        The incident took place just past three o’clock, when tea was steeping and eyes were elsewhere.
                        But fate, ever the meddler, ensured that Lady Vivenne Ashcombe was tending her roses on that
                        very path—and witnessed the entire spectacle, wide-brimmed hat and all. According to her account
                        (repeated many times since): “They were tangled together like ribbon in a sewing basket. And not
                        just because of the ride.”...
                    </p>
                </div>
            </div>
        </div>

        <footer class="footer">
            <h3>&copy; &nbsp;&nbsp; 2025 &nbsp; THE &nbsp; TEA &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; ALL
                &nbsp; GOSSIP &nbsp; SERVED &nbsp; HOT &nbsp;&nbsp;&nbsp; ☕ </h3>
        </footer>
        <script src="script.js"></script>
    </div>
</body>

</html>