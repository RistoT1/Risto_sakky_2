<?php
// Secure session setup
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/risto_sakky_2/elokuvaVuokraus';
$currentPath = $_SERVER['REQUEST_URI'];

function isActive($link) {
    global $currentPath;
    $current = strtok($currentPath, '?');
    return $current === $link ? 'active' : '';
}

$loggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>

<nav>
    <div class="navbar">
        <a href="<?= $base ?>/index.php" class="brand">Brand</a>
        <ul class="nav-links">
            <li><a href="<?= $base ?>/index.php" class="<?= isActive($base . '/index.php') ?>">Koti</a></li>
            
            <?php if ($loggedIn): ?>
                <li><a href="<?= $base ?>/pages/dashboard.php" class="<?= isActive($base . '/pages/dashboard.php') ?>">Dashboard</a></li>
                <?php if ($isAdmin): ?>
                    <li><a href="<?= $base ?>/admin/pages/admin.php" class="<?= isActive($base . '/admin/pages/admin.php') ?>">Admin Panel</a></li>
                <?php endif; ?>
                <li><a href="#" id="logoutBtn">Kirjaudu ulos</a></li>
            <?php else: ?>
                <li><a href="<?= $base ?>/pages/logIn.php" class="<?= isActive($base . '/pages/logIn.php') ?>">Kirjaudu</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<script>
const BASE = '<?= $base ?>';
document.getElementById('logoutBtn')?.addEventListener('click', async (e) => {
    e.preventDefault();
    await fetch(`${BASE}/api/logout.php`, { method: 'POST', credentials: 'include' });
    window.location.href = `${BASE}/index.php`;
});
</script>
