<?php
/**
 * Homepage dell'applicazione EnigmaMaster
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.3.0
 */
session_start();
include 'config.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");
?>
<!DOCTYPE html>
<html lang="<?= $language ?>" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="d-flex flex-column min-vh-100 bg-dark text-light">
    <?php include 'components/navbar.php'; ?>

    <main class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
              <div class="card bg-dark text-light shadow-lg border-0 animate__animated animate__fadeIn">
                    <div class="card-header text-center py-4">
                        <h1 class="display-4 fw-bold mb-0"><?= $lang['welcome'] ?></h1>
                    </div>
                    <div class="card-body p-5">
                        <p class="lead text-center text-light  mb-5"><?= $lang['challenge'] ?></p>
                        
                        <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <?php if (isset($_SESSION['utente_id'])): ?>
                                <a href="selezione_categoria.php" class="btn btn-primary btn-lg px-5 py-3">
                                    <i class="bi bi-play-circle me-2"></i>
                                    <?= $lang['play_game'] ?>
                                </a>
                            <?php else: ?>
                                <a href="register.php" class="btn btn-primary btn-lg px-5 py-3">
                                    <i class="bi bi-person-plus me-2"></i>
                                    <?= $lang['register_button'] ?>
                                </a>
                                <a href="selezione_categoria.php" class="btn btn-outline-primary btn-lg px-5 py-3">
                                    <i class="bi bi-joystick me-2"></i>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Abilita i tooltip di Bootstrap
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>