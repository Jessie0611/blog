<?php
// index.php (replace existing loop portion with this file or adapt)
require_once 'data/posts.php';
include 'header.php';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$filtered = $posts;
if ($q !== '') {
    $q_l = mb_strtolower($q);
    $filtered = array_filter($posts, function ($p) use ($q_l) {
        return (mb_stripos($p['title'], $q_l) !== false) || (mb_stripos($p['excerpt'], $q_l) !== false) || (mb_stripos($p['content'], $q_l) !== false) || (mb_stripos($p['category'], $q_l) !== false);
    });
}

// randomize and take up to 5
$shuffled = $filtered;
shuffle($shuffled);
$show = array_slice($shuffled, 0, 5);
?>
<main class="container">
    <div style="max-width:1100px;margin:18px auto 28px;padding:0 20px;">
        <form method="get" class="search-form" style="display:flex;gap:8px;align-items:center;">
            <input name="q" placeholder="Search posts..." value="<?php echo htmlspecialchars($q); ?>" class="input" style="flex:1;max-width:560px">
            <button class="btn" style="padding:10px 14px">Search</button>
            <?php if ($q !== ''): ?>
                <a href="index.php" class="btn secondary" style="margin-left:8px">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (empty($show)): ?>
        <div class="center" style="padding:40px 20px">
            <h2>No posts found</h2>
            <p class="lead">Try a different search or clear the query to show random posts.</p>
        </div>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($show as $p): ?>
                <article class="card">
                    <?php if (!empty($p['image']) && file_exists($p['image'])): ?>
                        <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
                    <?php endif; ?>
                    <div class="meta"><?php echo date('M j, Y', strtotime($p['date'])); ?> · <?php echo htmlspecialchars($p['category']); ?></div>
                    <h3><a href="viewPost.php?id=<?php echo $p['id']; ?>" style="color:inherit;text-decoration:none"><?php echo htmlspecialchars($p['title']); ?></a></h3>
                    <p class="lead"><?php echo htmlspecialchars($p['excerpt']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php
include 'footer.php';
?>