<?php
/**
 * Pagina di game over quando il giocatore esaurisce i tentativi
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.1.0
 * @link https://getbootstrap.com/docs/5.3/components/alerts/
 */
session_start();
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");

$punteggio_finale = $_SESSION['punteggio'] ?? 0;
unset($_SESSION['punteggio'], $_SESSION['tentativi'], $_SESSION['enigma_corrente']);
?>

<!DOCTYPE html>
<html lang="<?= $language ?>" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['game_over'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-dark text-light">
    <?php include 'components/navbar.php'; ?>

    <main class="flex-grow-1 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card bg-dark border-danger text-center shadow-lg">
                        <div class="card-body p-5">
                            <div class="mb-4">
                                <i class="bi bi-emoji-frown display-1 text-danger"></i>
                            </div>
                            <h2 class="card-title fw-bold mb-3"><?= $lang['game_over'] ?></h2>
                            <p class="card-text lead mb-4">
                                <?= $lang['game_over_message'] ?>
                                <span class="fw-bold text-primary"><?= $punteggio_finale ?></span>
                            </p>
                            <div class="d-grid gap-3">
                                <a href="index.php" class="btn btn-primary btn-lg py-2">
                                    <i class="bi bi-house-door me-2"></i>
                                    <?= $lang['back_home_button'] ?>
                                </a>
                                <a href="leaderboard.php" class="btn btn-outline-primary btn-lg py-2">
                                    <i class="bi bi-trophy me-2"></i>
                                    <?= $lang['view_leaderboard_button'] ?>
                                </a>
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
