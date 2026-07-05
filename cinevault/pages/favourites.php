<?php
require_once '../includes/db.php';
$root = '../';
$page_title = 'My Favourites';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'favourites.php';
    header('Location: login.php'); exit;
}

$uid = (int)$_SESSION['user_id'];

// Remove from favourites
if (isset($_GET['remove'])) {
    $mid = (int)$_GET['remove'];
    mysqli_query($conn, "DELETE FROM favourites WHERE user_id=$uid AND movie_id=$mid");
    header('Location: favourites.php'); exit;
}

$favs = mysqli_query($conn, "
    SELECT m.* FROM favourites f
    JOIN movies m ON f.movie_id = m.id
    WHERE f.user_id = $uid
    ORDER BY f.created_at DESC
");
$count = mysqli_num_rows($favs);
?>
<?php include '../includes/header.php'; ?>

<div class="section">
    <h1 style="color:var(--beige);margin-bottom:24px;">❤️ My Favourites</h1>

    <?php if ($count === 0): ?>
        <div class="empty-state">
            <div class="empty-icon">🎬</div>
            <h3>No favourites yet</h3>
            <p>Browse movies and click "Add to Favourites" to save them here.</p>
            <a href="search.php" class="btn-primary" style="margin-top:16px;display:inline-block;">Browse Movies</a>
        </div>
    <?php else: ?>
        <p style="color:var(--muted);margin-bottom:20px;"><?= $count ?> saved film<?= $count !== 1 ? 's' : '' ?></p>
        <div class="movies-grid">
            <?php while ($movie = mysqli_fetch_assoc($favs)): ?>
                <div class="movie-card">
                    <?php if ($movie['poster_url']): ?>
                        <img src="<?= htmlspecialchars($movie['poster_url']) ?>"
                             alt="<?= htmlspecialchars($movie['title']) ?>"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                        <div style="display:none;width:100%;aspect-ratio:2/3;background:#1a1a1a;align-items:center;justify-content:center;font-size:3rem;">🎬</div>
                    <?php else: ?>
                        <div style="width:100%;aspect-ratio:2/3;background:#1a1a1a;display:flex;align-items:center;justify-content:center;font-size:3rem;">🎬</div>
                    <?php endif; ?>
                    <div class="movie-card-body">
                        <div class="movie-card-title"><?= htmlspecialchars($movie['title']) ?></div>
                        <div class="movie-card-meta"><?= $movie['year'] ?> · <?= htmlspecialchars($movie['genre']) ?></div>
                        <div class="movie-card-rating">
                            <?php $r = round($movie['rating_avg']); echo str_repeat('★', $r) . str_repeat('☆', 5-$r); ?>
                        </div>
                        <div style="display:flex;gap:6px;">
                            <a href="movie.php?id=<?= $movie['id'] ?>" class="btn-primary btn-sm">Details</a>
                            <a href="favourites.php?remove=<?= $movie['id'] ?>" class="btn-sm btn-danger"
                               onclick="return confirm('Remove from favourites?')">✕</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
