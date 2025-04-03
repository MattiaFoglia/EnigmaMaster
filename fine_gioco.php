<?php
session_start();
include 'config.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");

$punteggio = $_SESSION['punteggio'] ?? 0;

if (isset($_SESSION['utente_id']) && isset($_SESSION['punteggio'])) {
    $id = $_SESSION['utente_id'];
    $punteggio_nuovo = intval($_SESSION['punteggio']);

    // Ottieni il punteggio attuale dell'utente
    $query = "SELECT punteggio FROM utenti WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $punteggio_attuale = $row['punteggio'];

            // Aggiorna solo se il nuovo punteggio è maggiore
            if ($punteggio_nuovo > $punteggio_attuale) {
                $update = "UPDATE utenti SET punteggio = ? WHERE id = ?";
                if ($stmt_update = mysqli_prepare($conn, $update)) {
                    mysqli_stmt_bind_param($stmt_update, 'ii', $punteggio_nuovo, $id);
                    mysqli_stmt_execute($stmt_update);
                }
            }
        }
        mysqli_stmt_close($stmt);
    }
}

// Pulisci la sessione
unset($_SESSION['question_count'], $_SESSION['total_score'], $_SESSION['enigma_api'], $_SESSION['tentativi']);
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $lang['game_over'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css"> 
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">EnigmaMaster</a>
    </div>
</nav>

<!-- Fine Gioco -->
<div class="container text-center mt-5">
    <h1 class="display-4"><?= $lang['congratulations'] ?></h1>
    <p class="lead"><?= $lang['completed_game'] ?></p>

    <p class="fs-4"><?= $lang['final_score'] ?> <strong><?= $punteggio ?></strong></p>

    <div class="mt-4">
        <a href="index.php" class="btn btn-primary"><?= $lang['back_home'] ?></a>
        <a href="leaderboard.php" class="btn btn-secondary"><?= $lang['view_leaderboard'] ?></a>
        <a href="gioco.php" class="btn btn-success"><?= $lang['play_again'] ?></a>
    </div>
</div>

<!-- Footer -->
<footer class="text-white text-center py-3 mt-5">
    <p>&copy; 2025 EnigmaMaster</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Chiudi la connessione al database
mysqli_close($conn);
?>