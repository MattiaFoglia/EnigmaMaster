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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-joystick me-2"></i>EnigmaMaster
        </a>

        <!-- Toggle per mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenuto navbar -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Menu principale -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>" href="index.php">
                        <i class="bi bi-house-door me-1"></i>
                        <?= $lang['home'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'leaderboard.php' ? 'active' : '' ?>" href="leaderboard.php">
                        <i class="bi bi-trophy me-1"></i>
                        <?= $lang['leaderboard'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'info.php' ? 'active' : '' ?>" href="info.php">
                        <i class="bi bi-info-circle me-1"></i>
                        <?= $lang['information'] ?>
                    </a>
                </li>

                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                <li class="nav-item">
                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) === 'admin.php') ? 'active' : '' ?>" 
                       href="admin.php">
                        <i class="bi bi-shield-lock me-1"></i>
                        <?= $lang['admin_panel'] ?? 'Admin' ?>
                    </a>
                </li>
                <?php endif; ?>
            </ul>

            <!-- Controlli lato destro -->
            <div class="d-flex align-items-center">
                <!-- Selettore lingua -->
                <div class="btn-group me-3 d-none d-sm-flex">
                    <a href="language.php?lang=it" class="btn btn-sm btn-outline-light <?= $_SESSION['lang'] === 'it' ? 'active' : '' ?>">
                        <i class="bi bi-translate me-1"></i> IT
                    </a>
                    <a href="language.php?lang=eng" class="btn btn-sm btn-outline-light <?= $_SESSION['lang'] === 'eng' ? 'active' : '' ?>">
                        <i class="bi bi-globe me-1"></i> EN
                    </a>
                </div>

                <!-- Menu utente -->
                <?php if (isset($_SESSION['utente_id'])): ?>
                     <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="avatar-sm me-2 bg-primary">
                                <?= strtoupper(substr(htmlspecialchars($_SESSION['nome']), 0, 1)) ?>
                            </div>
                            <span class="d-none d-lg-inline"><?= htmlspecialchars($_SESSION['nome']) ?></span>
                        </a>
                    
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> <?= $lang['logout'] ?></a></li>
                        </ul>
                    </div>
                   
                
                 <?php else: ?> 
                    
                    <a href="login.php" class="btn btn-outline-light btn-sm me-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        <span class="d-none d-sm-inline"><?= $lang['login'] ?></span>
                    </a>
                    <a href="register.php" class="btn btn-primary btn-sm">
                        <i class="bi bi-person-plus me-1"></i>
                        <span class="d-none d-sm-inline"><?= $lang['register'] ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>