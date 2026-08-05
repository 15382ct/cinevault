<?php
require_once '../includes/db.php';
$root = '../';
$page_title = 'Sign In';

if (isset($_SESSION['user_id'])) { header('Location: ../index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = $_POST['password'];

    if (!$email || !$password) {
        $error = 'Please fill in all fields.';
    } else {
        $res = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        $user = mysqli_fetch_assoc($res);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: ' . ($_SESSION['redirect_after_login'] ?? '../index.php'));
            unset($_SESSION['redirect_after_login']);
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="form-page">
    <div class="form-card">
        <h2>Welcome Back</h2>
        <p class="form-sub">Sign in to your CineVault account</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-primary btn-full">Sign In</button>
        </form>

        <div class="form-footer">
            Don't have an account? <a href="register.php">Create one for free →</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
