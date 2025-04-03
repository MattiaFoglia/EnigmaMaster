<?php
session_start();
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it'; // Usa la lingua della sessione, default è 'it'

include("lang/lang_$language.php");

// Recupera il punteggio finale
$punteggio_finale = isset($_SESSION['punteggio']) ? $_SESSION['punteggio'] : 0;

// Resetta il punteggio e i tentativi
unset($_SESSION['punteggio']);
unset($_SESSION['tentativi']);
unset($_SESSION['enigma_corrente']);
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['game_over'] ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="bg-light">

<div class="container mt-5 text-center">
    <div class="alert alert-danger">
        <h4 class="alert-heading"><?= $lang['game_over'] ?></h4>
        <p><?= $lang['game_over_message'] ?> <strong><?= $punteggio_finale ?></strong></p> <!-- Mostra il punteggio finale -->
        <hr>
        <a href="index.php" class="btn btn-primary"><?= $lang['back_home_button'] ?></a>
        <a href="leaderboard.php" class="btn btn-secondary"><?= $lang['view_leaderboard_button'] ?></a>
    </div>
</div>

    <!-- Footer -->
    <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EnigmaMaster</p>
    </footer>

<!-- Inclusione di Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
