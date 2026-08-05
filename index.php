<?php
require_once 'includes/db.php';
$root = '';

// Random featured movies
$featured = mysqli_query($conn, "SELECT * FROM movies ORDER BY RAND() LIMIT 8");

// All genres for pills
$genres = ['Action','Animation','Crime','Drama','Fantasy','Horror','Romance','Sci-Fi','Thriller'];
?>
<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="hero">
    <h1>Discover Your Next<br>Favourite Film</h1>
    <p>Browse, rate and review thousands of films. Join the community.</p>
    <form class="search-bar-wrap" action="pages/search.php" method="GET" style="max-width:600px;margin:0 auto 24px;">
        <input type="text" name="q" placeholder="Search by title, director or genre..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button type="submit">Search</button>
    </form>
    <div class="hero-btns">
        <a href="pages/search.php" class="btn-primary">Browse All Movies</a>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="pages/register.php" class="btn-outline">Create Account</a>
        <?php endif; ?>
    </div>
</section>

<!-- GENRE PILLS -->
<div class="section" style="padding-bottom:0;">
    <div class="genre-pills">
        <a href="pages/search.php" class="genre-pill">All</a>
        <?php foreach ($genres as $g): ?>
            <a href="pages/search.php?genre=<?= urlencode($g) ?>" class="genre-pill"><?= $g ?></a>
        <?php endforeach; ?>
    </div>
</div>

<!-- FEATURED MOVIES -->
<div class="section">
    <div class="section-header">
        <h2>⭐ Featured Movies</h2>
        <a href="pages/search.php">View all →</a>
    </div>
    <div class="movies-grid">
        <?php while ($movie = mysqli_fetch_assoc($featured)): ?>
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
                        <?php
                        $r = round($movie['rating_avg']);
                        echo str_repeat('★', $r) . str_repeat('☆', 5 - $r);
                        echo ' ' . number_format($movie['rating_avg'], 1);
                        ?>
                    </div>
                    <a href="pages/movie.php?id=<?= $movie['id'] ?>" class="btn-primary">View Details</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
