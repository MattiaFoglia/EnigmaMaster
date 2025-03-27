<?php
session_start();

// Recupera il punteggio finale
$punteggio_finale = isset($_SESSION['punteggio']) ? $_SESSION['punteggio'] : 0;

// Resetta il punteggio e i tentativi
unset($_SESSION['punteggio']);
unset($_SESSION['tentativi']);
unset($_SESSION['enigma_corrente']);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Game Over</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 text-center">
    <div class="alert alert-danger">
        <h4 class="alert-heading">Game Over</h4>
        <hr>
        <a href="index.php" class="btn btn-primary">Torna alla Home</a>
        <a href="leaderboard.php" class="btn btn-secondary">Vedi la Leaderboard</a>
    </div>
</div>
</body>
</html>
