<?php
/**
 * Pagina informativa con le regole del gioco
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.1.0
 * @link https://getbootstrap.com/docs/5.3/components/card/
 */
session_start();
include 'config.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['game_info_title'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <main class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0"><?= $lang['info_game_title'] ?></h2>
            </div>
            <div class="card-body">
                <p class="lead"><?= $lang['game_description'] ?></p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= $lang['game_rules_title'] ?></h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><?= $lang['game_rules_1'] ?></li>
                                    <li class="list-group-item"><?= $lang['game_rules_2'] ?></li>
                                    <li class="list-group-item"><?= $lang['game_rules_3'] ?></li>
                                    <li class="list-group-item"><?= $lang['game_rules_4'] ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= $lang['start_playing'] ?></h5>
                                <div class="d-grid gap-2">
                                    <?php if (isset($_SESSION['utente_id'])): ?>
                                        <a href="selezione_categoria.php" class="btn btn-success">
                                            <?= $lang['play_game'] ?>
                                        </a>
                                    <?php else: ?>
                                        <a href="register.php" class="btn btn-primary">
                                            <?= $lang['register_button'] ?>
                                        </a>
                                        <a href="selezione_categoria.php" class="btn btn-outline-primary">
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
    </main>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>