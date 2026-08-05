<?php
require_once '../includes/db.php';
$root = '../';
$page_title = 'My Account';

if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$uid = (int)$_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$uid"));

$msg = '';
$tab = $_GET['tab'] ?? 'reviews';

// Delete review
if (isset($_GET['delete_review'])) {
    $rid = (int)$_GET['delete_review'];
    $rev = mysqli_fetch_assoc(mysqli_query($conn, "SELECT movie_id FROM reviews WHERE id=$rid AND user_id=$uid"));
    if ($rev) {
        mysqli_query($conn, "DELETE FROM reviews WHERE id=$rid AND user_id=$uid");
        mysqli_query($conn, "UPDATE movies SET rating_avg = COALESCE((SELECT AVG(rating) FROM reviews WHERE movie_id={$rev['movie_id']}), 0) WHERE id={$rev['movie_id']}");
        $msg = '<div class="alert alert-success">Review deleted.</div>';
    }
    header('Location: account.php?tab=reviews'); exit;
}

// Update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $new_username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $new_email    = trim(mysqli_real_escape_string($conn, $_POST['email']));

    if (!$new_username || !$new_email) {
        $msg = '<div class="alert alert-error">Please fill in all fields.</div>';
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $msg = '<div class="alert alert-error">Invalid email address.</div>';
    } else {
        $check = mysqli_query($conn, "SELECT id FROM users WHERE (email='$new_email' OR username='$new_username') AND id!=$uid");
        if (mysqli_num_rows($check) > 0) {
            $msg = '<div class="alert alert-error">Email or username already taken.</div>';
        } else {
            mysqli_query($conn, "UPDATE users SET username='$new_username', email='$new_email' WHERE id=$uid");
            $_SESSION['username'] = $new_username;
            $user['username'] = $new_username;
            $user['email'] = $new_email;

            if (!empty($_POST['new_password'])) {
                if ($_POST['new_password'] !== $_POST['confirm_password']) {
                    $msg = '<div class="alert alert-error">Passwords do not match.</div>';
                } elseif (strlen($_POST['new_password']) < 6) {
                    $msg = '<div class="alert alert-error">Password must be at least 6 characters.</div>';
                } else {
                    $hashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    mysqli_query($conn, "UPDATE users SET password='$hashed' WHERE id=$uid");
                    $msg = '<div class="alert alert-success">Profile and password updated!</div>';
                }
            } else {
                $msg = '<div class="alert alert-success">Profile updated successfully!</div>';
            }
        }
    }
    $tab = 'settings';
}

// Get reviews
$reviews = mysqli_query($conn, "
    SELECT r.*, m.title, m.id as movie_id FROM reviews r
    JOIN movies m ON r.movie_id = m.id
    WHERE r.user_id = $uid
    ORDER BY r.created_at DESC
");
$review_count = mysqli_num_rows($reviews);

// Get favourites count
$fav_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM favourites WHERE user_id=$uid"));
?>
<?php include '../includes/header.php'; ?>

<div class="account-layout">
    <!-- Sidebar -->
    <div class="account-sidebar">
        <div class="account-avatar"><?= strtoupper(substr($user['username'], 0, 1)) ?></div>
        <div class="account-name"><?= htmlspecialchars($user['username']) ?></div>
        <div class="account-email"><?= htmlspecialchars($user['email']) ?></div>
        <div style="display:flex;gap:16px;margin-bottom:20px;font-size:0.85rem;">
            <div><strong style="color:var(--beige);"><?= $review_count ?></strong><br><span style="color:var(--muted);">Reviews</span></div>
            <div><strong style="color:var(--beige);"><?= $fav_count ?></strong><br><span style="color:var(--muted);">Favourites</span></div>
        </div>
        <nav class="sidebar-nav">
            <a href="account.php?tab=reviews" class="<?= $tab === 'reviews' ? 'active' : '' ?>">📝 My Reviews</a>
            <a href="favourites.php">❤️ Favourites</a>
            <a href="account.php?tab=settings" class="<?= $tab === 'settings' ? 'active' : '' ?>">⚙️ Settings</a>
            <a href="logout.php" style="margin-top:12px;color:var(--muted);">🚪 Logout</a>
        </nav>
    </div>

    <!-- Main content -->
    <div class="account-content">
        <?= $msg ?>

        <?php if ($tab === 'reviews'): ?>
            <h2>My Reviews</h2>
            <?php if ($review_count === 0): ?>
                <div class="empty-state" style="padding:30px 0;">
                    <div class="empty-icon">💬</div>
                    <h3>No reviews yet</h3>
                    <p>Start reviewing your favourite films!</p>
                    <a href="search.php" class="btn-primary" style="margin-top:12px;display:inline-block;">Browse Movies</a>
                </div>
            <?php else: ?>
                <?php while ($rev = mysqli_fetch_assoc($reviews)): ?>
                    <div class="account-review-item">
                        <div style="flex:1;">
                            <a href="movie.php?id=<?= $rev['movie_id'] ?>" style="font-weight:600;color:var(--beige);">
                                <?= htmlspecialchars($rev['title']) ?>
                            </a>
                            <div class="stars" style="margin:4px 0;"><?= str_repeat('★', $rev['rating']) ?><span style="color:var(--border);"><?= str_repeat('★', 5-$rev['rating']) ?></span></div>
                            <?php if ($rev['comment']): ?>
                                <p style="font-size:0.87rem;color:#cccccc;margin-top:4px;"><?= htmlspecialchars($rev['comment']) ?></p>
                            <?php endif; ?>
                            <p style="font-size:0.75rem;color:var(--muted);margin-top:6px;"><?= date('d M Y', strtotime($rev['created_at'])) ?></p>
                        </div>
                        <div class="account-review-actions">
                            <a href="movie.php?id=<?= $rev['movie_id'] ?>" class="btn-sm btn-edit">Edit</a>
                            <a href="account.php?delete_review=<?= $rev['id'] ?>"
                               class="btn-sm btn-danger"
                               onclick="return confirm('Delete this review?')">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

        <?php elseif ($tab === 'settings'): ?>
            <h2>Account Settings</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <hr style="border-color:var(--border);margin:20px 0;">
                <p style="color:var(--muted);font-size:0.85rem;margin-bottom:16px;">Leave blank to keep your current password.</p>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" placeholder="Min. 6 characters">
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" placeholder="Repeat new password">
                </div>
                <button type="submit" name="update_profile" class="btn-primary">Save Changes</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
