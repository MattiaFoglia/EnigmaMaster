<?php
/**
 * Pagina informativa con le regole del gioco
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.2.0
 * @link https://getbootstrap.com/docs/5.3/components/card/
 */
session_start();
include 'config.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");
?>

<!DOCTYPE html>
<html lang="<?= $language ?>" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['info_game_title'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-dark text-light">
    <?php include 'components/navbar.php'; ?>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="card bg-dark border-primary shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0"><?= $lang['info_game_title'] ?></h2>
                </div>
                <div class="card-body">
                    <p class="lead"><?= $lang['game_description'] ?></p>
                    
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="card bg-dark border-secondary mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="bi bi-list-check me-2"></i>
                                        <?= $lang['game_rules_title'] ?>
                                    </h5>
                                    <ul class="list-group list-group-flush bg-transparent">
                                        <li class="list-group-item bg-transparent text-light border-secondary">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <?= $lang['game_rules_1'] ?>
                                        </li>
                                        <li class="list-group-item bg-transparent text-light border-secondary">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <?= $lang['game_rules_2'] ?>
                                        </li>
                                        <li class="list-group-item bg-transparent text-light border-secondary">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <?= $lang['game_rules_3'] ?>
                                        </li>
                                        <li class="list-group-item bg-transparent text-light border-secondary">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <?= $lang['game_rules_4'] ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card bg-dark border-secondary">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="bi bi-controller me-2"></i>
                                        <?= $lang['start_playing'] ?>
                                    </h5>
                                    <div class="d-grid gap-3">
                                        <?php if (isset($_SESSION['utente_id'])): ?>
                                            <a href="selezione_categoria.php" class="btn btn-success">
                                                <i class="bi bi-play-fill me-2"></i>
                                                <?= $lang['play_game'] ?>
                                            </a>
                                        <?php else: ?>
                                            <a href="register.php" class="btn btn-primary">
                                                <i class="bi bi-person-plus me-2"></i>
                                                <?= $lang['register_button'] ?>
                                            </a>
                                            <a href="selezione_categoria.php" class="btn btn-outline-primary">
                                                <i class="bi bi-joystick me-2"></i>
                                                <?= $lang['guest_play'] ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>