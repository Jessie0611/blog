<?php
// viewPost.php
// Expects: data/posts.php which defines $posts as an array of posts.
// Example URL: viewPost.php?id=1

require_once 'data/posts.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = null;
foreach ($posts as $p) {
    if (isset($p['id']) && (int)$p['id'] === $id) {
        $post = $p;
        break;
    }
}
include 'header.php';

if (!$post) {
?>
    <main class="container">
        <div class="center" style="padding:60px 20px">
            <h2>Post not found</h2>
            <p class="lead">We couldn't find the post you're looking for. Try returning to the <a href="index.php">home page</a>.</p>
        </div>
    </main>
<?php
    if (file_exists('footer.php')) include 'footer.php';
    exit;
}

// Render post
?>
<main class="container">
    <article class="post-hero">
        <?php if (!empty($post['image']) && file_exists($post['image'])): ?>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" style="width:100%;max-height:420px;object-fit:cover;border-radius:10px;margin-bottom:16px">
        <?php endif; ?>
        <div class="meta"><?php echo date('F j, Y', strtotime($post['date'])); ?> · <?php echo htmlspecialchars($post['category'] ?? ''); ?></div>
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <?php if (!empty($post['excerpt'])): ?>
            <p class="lead" style="margin-top:8px"><?php echo htmlspecialchars($post['excerpt']); ?></p>
        <?php endif; ?>
    </article>

    <section class="post-content" style="margin-top:18px">
        <?php
        // Support content as string or as array of paragraphs
        $content = $post['content'] ?? '';
        if (is_array($content)) {
            foreach ($content as $para) {
                echo '<p>' . nl2br(htmlspecialchars($para)) . '</p>';
            }
        } else {
            echo '<p>' . nl2br(htmlspecialchars($content)) . '</p>';
        }
        ?>
    </section>
</main>

<?php
include 'footer.php';
?>