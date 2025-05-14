<?php
/**
 * Category selection page for the game
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.2.0
 * @link https://getbootstrap.com/docs/5.3/forms/radio-buttons/
 * @link https://icons.getbootstrap.com/
 */
session_start();
include 'config.php';
include 'api.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");

$categories = ottieniCategorieAPI();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
    $_SESSION['categoria_selezionata'] = (int)$_POST['categoria'];
    $_SESSION['question_count'] = 0;
    $_SESSION['total_score'] = 0;
    header("Location: gioco.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?= $language ?>" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['select_category'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-dark text-light">
    <?php include 'components/navbar.php'; ?>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card bg-dark border-primary shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h2 class="mb-0 text-center">
                                <i class="bi bi-list-ul me-2"></i>
                                <?= $lang['select_category'] ?>
                            </h2>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            <form method="POST" action="selezione_categoria.php">
                                <div class="row g-4">
                                    <?php foreach ($categories as $id => $name): ?>
                                        <div class="col-md-4 col-sm-6">
                                            <input type="radio" 
                                                   class="btn-check" 
                                                   name="categoria" 
                                                   id="categoria<?= $id ?>" 
                                                   value="<?= $id ?>" 
                                                   autocomplete="off" 
                                                   required>
                                            <label class="w-100" for="categoria<?= $id ?>">
                                                <div class="card bg-dark border-secondary h-100 category-card">
                                                    <div class="card-body text-center p-4 d-flex flex-column">
                                                        <div class="category-icon text-primary mb-3">
                                                            <?php 
                                                            $icon = 'bi bi-question-circle';
                                                            if (strpos($name, 'Science') !== false) {
                                                                $icon = 'bi bi-robot';
                                                            } elseif (strpos($name, 'Entertainment') !== false) {
                                                                $icon = 'bi bi-film';
                                                            } elseif (strpos($name, 'Art') !== false) {
                                                                $icon = 'bi bi-palette';
                                                            } elseif (strpos($name, 'History') !== false) {
                                                                $icon = 'bi bi-hourglass';
                                                            }
                                                            ?>
                                                            <i class="<?= $icon ?> display-4"></i>
                                                        </div>
                                                        <h5 class="card-title fw-bold mt-auto"><?= htmlspecialchars($name) ?></h5>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg py-3">
                                        <i class="bi bi-play-fill me-2"></i>
                                        <?= $lang['start_game'] ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-check').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.category-card').forEach(card => {
                    card.classList.remove('border-primary', 'bg-primary', 'text-white');
                });
                
                if(this.checked) {
                    const card = this.nextElementSibling.querySelector('.category-card');
                    card.classList.add('border-primary', 'bg-primary', 'text-white');
                }
            });
        });
    </script>
</body>
</html>
