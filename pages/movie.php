<?php
require_once '../includes/db.php';
$root = '../';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: ../index.php'); exit; }

$movie = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM movies WHERE id = $id"));
if (!$movie) { header('Location: ../index.php'); exit; }

$page_title = $movie['title'];

// Handle review submission
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $rating = (int)$_POST['rating'];
    $comment = trim(mysqli_real_escape_string($conn, $_POST['comment']));
    $uid = (int)$_SESSION['user_id'];

    if ($rating < 1 || $rating > 5) {
        $msg = '<div class="alert alert-error">Please select a star rating.</div>';
    } else {
        $check = mysqli_query($conn, "SELECT id FROM reviews WHERE user_id=$uid AND movie_id=$id");
        if (mysqli_num_rows($check) > 0) {
            mysqli_query($conn, "UPDATE reviews SET rating=$rating, comment='$comment' WHERE user_id=$uid AND movie_id=$id");
        } else {
            mysqli_query($conn, "INSERT INTO reviews (user_id, movie_id, rating, comment) VALUES ($uid, $id, $rating, '$comment')");
        }
        // Update movie average
        mysqli_query($conn, "UPDATE movies SET rating_avg = (SELECT AVG(rating) FROM reviews WHERE movie_id=$id) WHERE id=$id");
        $movie = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM movies WHERE id=$id"));
        $msg = '<div class="alert alert-success">Your review has been saved!</div>';
    }
}

// Handle favourite toggle
if (isset($_POST['toggle_fav']) && isset($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $check = mysqli_query($conn, "SELECT id FROM favourites WHERE user_id=$uid AND movie_id=$id");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM favourites WHERE user_id=$uid AND movie_id=$id");
    } else {
        mysqli_query($conn, "INSERT INTO favourites (user_id, movie_id) VALUES ($uid, $id)");
    }
}

// Check if favourited
$is_fav = false;
if (isset($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $fav_check = mysqli_query($conn, "SELECT id FROM favourites WHERE user_id=$uid AND movie_id=$id");
    $is_fav = mysqli_num_rows($fav_check) > 0;
}

// Get reviews
$reviews = mysqli_query($conn, "
    SELECT r.*, u.username FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.movie_id = $id
    ORDER BY r.created_at DESC
");
$review_count = mysqli_num_rows($reviews);

// Get user's own review
$user_review = null;
if (isset($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $ur = mysqli_query($conn, "SELECT * FROM reviews WHERE user_id=$uid AND movie_id=$id");
    $user_review = mysqli_fetch_assoc($ur);
}
?>
<?php include '../includes/header.php'; ?>

<!-- BREADCRUMB -->
<div class="section" style="padding-bottom:0;">
    <p style="color:var(--muted);font-size:0.85rem;">
        <a href="../index.php" style="color:var(--beige);">Home</a> › 
        <a href="search.php" style="color:var(--beige);">Movies</a> › 
        <?= htmlspecialchars($movie['title']) ?>
    </p>
</div>

<!-- MOVIE DETAIL -->
<div class="detail-hero">
    <div class="detail-poster">
        <?php if ($movie['poster_url']): ?>
            <img src="<?= htmlspecialchars($movie['poster_url']) ?>"
                 alt="<?= htmlspecialchars($movie['title']) ?>"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="detail-poster-placeholder" style="display:none;">🎬</div>
        <?php else: ?>
            <div class="detail-poster-placeholder">🎬</div>
        <?php endif; ?>
    </div>

    <div class="detail-info">
        <h1><?= htmlspecialchars($movie['title']) ?></h1>

        <div class="detail-meta">
            <span class="genre-tag"><?= htmlspecialchars($movie['genre']) ?></span>
            <span><?= $movie['year'] ?></span>
            <?php if ($movie['duration_min']): ?>
                <span><?= $movie['duration_min'] ?> min</span>
            <?php endif; ?>
        </div>

        <div class="detail-rating">
            <?php
            $r = round($movie['rating_avg']);
            echo '<span class="stars">' . str_repeat('★', $r) . '</span>';
            echo '<span class="stars-empty">' . str_repeat('★', 5 - $r) . '</span>';
            ?>
            <span class="rating-num"><?= number_format($movie['rating_avg'], 1) ?></span>
            <span class="rating-count">(<?= $review_count ?> review<?= $review_count !== 1 ? 's' : '' ?>)</span>
        </div>

        <p class="detail-desc"><?= htmlspecialchars($movie['description']) ?></p>

        <div class="detail-credits">
            <div class="detail-credit">
                <label>Director</label>
                <p><?= htmlspecialchars($movie['director']) ?></p>
            </div>
            <div class="detail-credit">
                <label>Cast</label>
                <p><?= htmlspecialchars($movie['cast_members']) ?></p>
            </div>
        </div>

        <div style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;">
            <?php if (isset($_SESSION['user_id'])): ?>
                <form method="POST">
                    <button type="submit" name="toggle_fav" class="fav-btn <?= $is_fav ? 'active' : '' ?>">
                        <?= $is_fav ? '❤️ Saved to Favourites' : '🤍 Add to Favourites' ?>
                    </button>
                </form>
            <?php else: ?>
                <a href="login.php" class="fav-btn">🤍 Add to Favourites</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- REVIEW SECTION -->
<div class="review-section">

    <!-- Submit Review -->
    <div class="review-box" style="margin-bottom:32px;">
        <h2>Leave a Review</h2>
        <?= $msg ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST">
                <p style="margin-bottom:12px;color:var(--muted);font-size:0.88rem;">Rating:</p>
                <div class="star-selector" id="starSelector">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>"
                               <?= ($user_review && $user_review['rating'] == $i) ? 'checked' : '' ?>>
                        <label for="star<?= $i ?>">★</label>
                    <?php endfor; ?>
                </div>
                <div class="form-group">
                    <textarea name="comment" rows="4" placeholder="Share your thoughts about this film..."
                        style="width:100%;padding:11px 14px;background:var(--dark);border:1px solid var(--border);border-radius:8px;color:var(--white);font-size:0.95rem;font-family:inherit;resize:vertical;"><?= htmlspecialchars($user_review['comment'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn-primary">
                    <?= $user_review ? 'Update Review' : 'Submit Review' ?>
                </button>
            </form>
        <?php else: ?>
            <p style="color:var(--muted);">
                <a href="login.php" style="color:var(--beige);">Sign in</a> or
                <a href="register.php" style="color:var(--beige);">create an account</a> to leave a review.
            </p>
        <?php endif; ?>
    </div>

    <!-- Community Reviews -->
    <h2 style="color:var(--beige);margin-bottom:16px;">Community Reviews</h2>

    <?php if ($review_count === 0): ?>
        <div class="empty-state">
            <div class="empty-icon">💬</div>
            <h3>No reviews yet</h3>
            <p>Be the first to review this film!</p>
        </div>
    <?php else: ?>
        <div class="reviews-list">
            <?php
            mysqli_data_seek($reviews, 0);
            while ($rev = mysqli_fetch_assoc($reviews)):
            ?>
                <div class="review-item">
                    <div class="review-item-header">
                        <span class="review-author">👤 <?= htmlspecialchars($rev['username']) ?></span>
                        <span class="review-date"><?= date('d M Y', strtotime($rev['created_at'])) ?></span>
                    </div>
                    <div class="stars" style="margin-bottom:8px;">
                        <?= str_repeat('★', $rev['rating']) ?><span style="color:var(--border);"><?= str_repeat('★', 5 - $rev['rating']) ?></span>
                    </div>
                    <?php if ($rev['comment']): ?>
                        <p class="review-comment"><?= htmlspecialchars($rev['comment']) ?></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
