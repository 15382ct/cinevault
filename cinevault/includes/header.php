<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVault<?= isset($page_title) ? ' — ' . htmlspecialchars($page_title) : '' ?></title>
    <link rel="stylesheet" href="<?= $root ?? '' ?>css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="<?= $root ?? '' ?>index.php" class="nav-logo">🎬 CineVault</a>

        <div class="nav-links">
            <a href="<?= $root ?? '' ?>index.php" class="<?= $current_page === 'index.php' ? 'active' : '' ?>">Home</a>

            <div class="dropdown">
                <a href="#">Genre ▾</a>
                <div class="dropdown-menu">
                    <?php
                    $genres = ['Action','Animation','Crime','Drama','Fantasy','Horror','Romance','Sci-Fi','Thriller'];
                    foreach ($genres as $g) {
                        echo '<a href="' . ($root ?? '') . 'pages/search.php?genre=' . urlencode($g) . '">' . $g . '</a>';
                    }
                    ?>
                </div>
            </div>

            <a href="<?= $root ?? '' ?>pages/search.php">Browse</a>
        </div>

        <div class="nav-auth">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="nav-user">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="<?= $root ?? '' ?>pages/account.php" class="btn-outline">My Account</a>
                <a href="<?= $root ?? '' ?>pages/logout.php" class="btn-outline">Logout</a>
            <?php else: ?>
                <a href="<?= $root ?? '' ?>pages/login.php" class="btn-outline">Sign In</a>
                <a href="<?= $root ?? '' ?>pages/register.php" class="btn-primary">Join Free</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
