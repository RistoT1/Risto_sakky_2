<?php $currentFile = basename($_SERVER['PHP_SELF']);
$root = basename(dirname($_SERVER['PHP_SELF'])) === 'pages' ? '../' : '';
?>
<nav>
    <div class="Title">
        <h1>OpiskelijaHallinta</h1>
    </div>
    <div class="nav-links">
        <ul>
            <li><a href="<?= $root ?>index.php" class="<?= $currentFile === 'index.php' ? 'active' : '' ?>">Home</a>
            </li>
            <li><a href="<?= $root ?>pages/Opiskelijat.php"
                    class="<?= $currentFile === 'Opiskelijat.php' ? 'active' : '' ?>">Opiskelijat</a></li>
            <li><a href="<?= $root ?>pages/Kurssit.php"
                    class="<?= $currentFile === 'Kurssit.php' ? 'active' : '' ?>">Kurssi</a></li>
            <li><a href="<?= $root ?>pages/Suoritukset.php"
                    class="<?= $currentFile === 'Suoritukset.php' ? 'active' : '' ?>">Suoritukset</a></li>
            <li><a href="<?= $root ?>pages/Ilmottaudu.php"
                    class="<?= $currentFile === 'Ilmottaudu.php' ? 'active' : '' ?>">Ilmottaudu</a></li>
        </ul>
    </div>
</nav>