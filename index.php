<?php
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
    <title>EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h1 class="display-4 mb-0"><?= $lang['welcome'] ?></h1>
                    </div>
                    <div class="card-body py-5">
                        <p class="lead text-muted mb-5"><?= $lang['challenge'] ?></p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <?php if (isset($_SESSION['utente_id'])): ?>
                                <a href="selezione_categoria.php" class="btn btn-primary btn-lg px-4">
                                    <?= $lang['play_game'] ?>
                                </a>
                            <?php else: ?>
                                <a href="register.php" class="btn btn-primary btn-lg px-4">
                                    <?= $lang['register_button'] ?>
                                </a>
                                <a href="selezione_categoria.php" class="btn btn-outline-primary btn-lg px-4">
                                    <?= $lang['guest_play'] ?>
                                </a>
                            <?php endif; ?>
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