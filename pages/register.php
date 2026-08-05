<?php
require_once '../includes/db.php';
$root = '../';
$page_title = 'Create Account';

if (isset($_SESSION['user_id'])) { header('Location: ../index.php'); exit; }

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email    = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if (!$username || !$email || !$password || !$confirm) {
        $error = 'Please fill in all fields.';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        // Check duplicates
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' OR username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = 'Email or username already in use.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed')");
            $uid = mysqli_insert_id($conn);
            $_SESSION['user_id'] = $uid;
            $_SESSION['username'] = $username;
            header('Location: ../index.php');
            exit;
        }
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="form-page">
    <div class="form-card">
        <h2>Join CineVault</h2>
        <p class="form-sub">Create your free account and start reviewing</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="cinelover" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Min. 6 characters" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm" placeholder="Repeat password" required>
            </div>
            <button type="submit" class="btn-primary btn-full">Create Account</button>
        </form>

        <div class="form-footer">
            Already have an account? <a href="login.php">Sign in →</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
