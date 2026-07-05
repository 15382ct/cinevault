<?php
require_once '../includes/db.php';
$root = '../';
$page_title = 'Browse Movies';

$q = trim($_GET['q'] ?? '');
$genre = trim($_GET['genre'] ?? '');

$where = [];
if ($q) $where[] = "(title LIKE '%" . mysqli_real_escape_string($conn, $q) . "%' OR director LIKE '%" . mysqli_real_escape_string($conn, $q) . "%')";
if ($genre) $where[] = "genre = '" . mysqli_real_escape_string($conn, $genre) . "'";
$sql = "SELECT * FROM movies" . ($where ? " WHERE " . implode(" AND ", $where) : "") . " ORDER BY rating_avg DESC";

$results = mysqli_query($conn, $sql);
$count = mysqli_num_rows($results);

$genres = ['Action','Animation','Crime','Drama','Fantasy','Horror','Romance','Sci-Fi','Thriller'];
?>
<?php include '../includes/header.php'; ?>

<div class="section">
    <h1 style="color:var(--beige);margin-bottom:20px;">
        <?= $genre ? htmlspecialchars($genre) . ' Movies' : ($q ? 'Results for "' . htmlspecialchars($q) . '"' : 'Browse All Movies') ?>
    </h1>

    <form class="search-bar-wrap" action="search.php" method="GET">
        <input type="text" name="q" placeholder="Search title or director..." value="<?= htmlspecialchars($q) ?>">
        <button type="submit">Search</button>
    </form>

    <div class="genre-pills" style="margin-bottom:28px;">
        <a href="search.php" class="genre-pill <?= !$genre ? 'active' : '' ?>">All</a>
        <?php foreach ($genres as $g): ?>
            <a href="search.php?genre=<?= urlencode($g) ?>" class="genre-pill <?= $genre === $g ? 'active' : '' ?>"><?= $g ?></a>
        <?php endforeach; ?>
    </div>

    <p style="color:var(--muted);margin-bottom:20px;font-size:0.88rem;"><?= $count ?> movie<?= $count !== 1 ? 's' : '' ?> found</p>

    <?php if ($count === 0): ?>
        <div class="empty-state">
            <div class="empty-icon">🎬</div>
            <h3>No movies found</h3>
            <p>Try a different search or genre.</p>
        </div>
    <?php else: ?>
        <div class="movies-grid">
            <?php while ($movie = mysqli_fetch_assoc($results)): ?>
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
                            <?php $r = round($movie['rating_avg']); echo str_repeat('★', $r) . str_repeat('☆', 5-$r) . ' ' . number_format($movie['rating_avg'],1); ?>
                        </div>
                        <a href="movie.php?id=<?= $movie['id'] ?>" class="btn-primary">View Details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
