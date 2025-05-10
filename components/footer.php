<?php
/**
 * Piè di pagina dell'applicazione
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.2.0
 * @link https://getbootstrap.com/docs/5.3/components/footer/
 */
?>
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <h3 class="h5 mb-3">
                    <i class="bi bi-joystick me-2"></i>EnigmaMaster
                </h3>
                <p class="text-secondary mb-4"><?= $lang['game_description'] ?></p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white hover-scale" data-bs-toggle="tooltip" title="Twitter">
                        <i class="bi bi-twitter fs-5"></i>
                    </a>
                    <a href="#" class="text-white hover-scale" data-bs-toggle="tooltip" title="Facebook">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <a href="#" class="text-white hover-scale" data-bs-toggle="tooltip" title="Instagram">
                        <i class="bi bi-instagram fs-5"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h5 class="h6 mb-3"><?= $lang['links'] ?></h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="index.php" class="text-secondary hover-text-white"><?= $lang['home'] ?></a></li>
                    <li class="mb-2"><a href="leaderboard.php" class="text-secondary hover-text-white"><?= $lang['leaderboard'] ?></a></li>
                    <li class="mb-2"><a href="info.php" class="text-secondary hover-text-white"><?= $lang['information'] ?></a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                <li class="mb-2">
                    <a <?= (basename($_SERVER['PHP_SELF']) === 'admin.php') ? 'active' : '' ?>" 
                       href="admin.php">
                        <?= $lang['admin_panel'] ?? 'Admin' ?>
                    </a>
                </li>
                <?php endif; ?>
                </ul>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <h5 class="h6 mb-3"><?= $lang['language'] ?></h5>
                <div class="d-flex gap-2">
                    <a href="language.php?lang=it" class="btn btn-outline-light btn-sm flex-grow-1 <?= $_SESSION['lang'] === 'it' ? 'active' : '' ?>">
                        <i class="bi bi-translate me-1"></i> Italiano
                    </a>
                    <a href="language.php?lang=eng" class="btn btn-outline-light btn-sm flex-grow-1 <?= $_SESSION['lang'] === 'eng' ? 'active' : '' ?>">
                        <i class="bi bi-globe me-1"></i> English
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center pt-4 mt-3 border-top border-secondary">
            <p class="small mb-0">EnigmaMaster</p>
        </div>
    </div>
</footer>