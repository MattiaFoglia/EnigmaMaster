<?php
/**
 * Barra di navigazione principale dell'applicazione
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.2.0
 * @link https://getbootstrap.com/docs/5.3/components/navbar/
 */
?>
    
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">EnigmaMaster</a>
        
        <div class="d-flex align-items-center order-lg-3">
            <div class="btn-group me-3">
                <a href="language.php?lang=it" class="btn btn-sm btn-light <?= $_SESSION['lang'] === 'it' ? 'active' : '' ?>">IT</a>
                <a href="language.php?lang=eng" class="btn btn-sm btn-light <?= $_SESSION['lang'] === 'eng' ? 'active' : '' ?>">EN</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        
        <div class="collapse navbar-collapse order-lg-2" id="mainNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>" href="index.php">
                        <?= $lang['home'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'leaderboard.php' ? 'active' : '' ?>" href="leaderboard.php">
                        <?= $lang['leaderboard'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'info.php' ? 'active' : '' ?>" href="info.php">
                        <?= $lang['information'] ?>
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['utente_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <?= htmlspecialchars($_SESSION['nome']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="logout.php"><?= $lang['logout'] ?></a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><?= $lang['login'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"><?= $lang['register'] ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>