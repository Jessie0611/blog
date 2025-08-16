<?php include 'header.php'; ?>

<div class="row">
    <div class="leftColumn">
        <div class="post">
            <!-- Dynamic posts from database -->
            <?php
            // Fetch latest 5 posts using PDO
            $stmt = $pdo->query("SELECT * FROM posts WHERE status = 'published';");
            $posts = $stmt->fetchAll();

            foreach ($posts as $row) {
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
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>