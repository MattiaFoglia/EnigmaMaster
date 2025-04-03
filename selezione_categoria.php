<?php
session_start();
include 'config.php';
include 'api.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");

// Ottieni le categorie disponibili dall'API
$categories = ottieniCategorieAPI();

// Se è stata selezionata una categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
    $_SESSION['categoria_selezionata'] = (int)$_POST['categoria'];
    $_SESSION['question_count'] = 0;
    $_SESSION['total_score'] = 0;
    header("Location: gioco.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['select_category'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .category-card {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .category-card:hover {
            transform: scale(1.03);
        }
        .category-radio {
            display: none;
        }
        .category-radio:checked + .category-card {
            border: 3px solid #0d6efd;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0"><?= $lang['select_category'] ?></h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="selezione_categoria.php">
                            <div class="row g-3">
                                <?php foreach ($categories as $id => $name): ?>
                                    <div class="col-md-6">
                                        <input type="radio" class="category-radio" name="categoria" 
                                               id="categoria<?= $id ?>" value="<?= $id ?>" required>
                                        <label for="categoria<?= $id ?>">
                                            <div class="category-card card h-100">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title"><?= htmlspecialchars($name) ?></h5>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    <?= $lang['start_game'] ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php
session_start();
include 'config.php';
include 'api.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");

// Ottieni le categorie disponibili dall'API
$categories = ottieniCategorieAPI();

// Se è stata selezionata una categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
    $_SESSION['categoria_selezionata'] = (int)$_POST['categoria'];
    $_SESSION['question_count'] = 0;
    $_SESSION['total_score'] = 0;
    header("Location: gioco.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['select_category'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .category-card {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .category-card:hover {
            transform: scale(1.03);
        }
        .category-radio {
            display: none;
        }
        .category-radio:checked + .category-card {
            border: 3px solid #0d6efd;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0"><?= $lang['select_category'] ?></h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="selezione_categoria.php">
                            <div class="row g-3">
                                <?php foreach ($categories as $id => $name): ?>
                                    <div class="col-md-6">
                                        <input type="radio" class="category-radio" name="categoria" 
                                               id="categoria<?= $id ?>" value="<?= $id ?>" required>
                                        <label for="categoria<?= $id ?>">
                                            <div class="category-card card h-100">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title"><?= htmlspecialchars($name) ?></h5>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    <?= $lang['start_game'] ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>