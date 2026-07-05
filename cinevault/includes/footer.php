
<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <span class="footer-logo">🎬 CineVault</span>
            <p>Your community movie review platform.</p>
        </div>
        <div class="footer-links">
            <a href="<?= $root ?? '' ?>index.php">Home</a>
            <a href="<?= $root ?? '' ?>pages/search.php">Browse</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= $root ?? '' ?>pages/account.php">My Account</a>
                <a href="<?= $root ?? '' ?>pages/favourites.php">Favourites</a>
            <?php else: ?>
                <a href="<?= $root ?? '' ?>pages/login.php">Sign In</a>
                <a href="<?= $root ?? '' ?>pages/register.php">Register</a>
            <?php endif; ?>
        </div>
        <p class="footer-copy">© 2025 CineVault — INT1059 Advanced Web | Marcella Galiotti & Cristina Tenorio</p>
    </div>
</footer>

<script src="<?= $root ?? '' ?>js/main.js"></script>
</body>
</html>
