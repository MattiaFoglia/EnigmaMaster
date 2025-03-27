<?php
session_start();
include 'config.php';

$punteggio = null;  // Inizializza la variabile $punteggio per evitare l'errore di variabile non definita.

if (isset($_SESSION['utente_id']) && isset($_POST['punteggio'])) {
    $id = $_SESSION['utente_id'];
    $punteggio_nuovo = intval($_POST['punteggio']);  // Converte il punteggio in un intero

    // Ottieni il punteggio attuale dell'utente
    $query = "SELECT punteggio FROM utenti WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);  // Usa i per il parametro intero
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Controlla se l'utente esiste
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

// Recupera il punteggio finale per visualizzarlo nella pagina
if (isset($_SESSION['utente_id'])) {
    $id = $_SESSION['utente_id'];
    $query = "SELECT punteggio FROM utenti WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $punteggio = $row['punteggio'];
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Fine del Gioco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h1 class="display-4">🎉 Complimenti!</h1>
    <p class="lead">Hai completato il gioco.</p>

    <?php if ($punteggio !== null): ?>
        <p class="fs-4">Il tuo punteggio finale è: <strong><?= $punteggio ?></strong></p>
    <?php else: ?>
        <p class="fs-5">Grazie per aver giocato!</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="index.php" class="btn btn-primary">Torna alla Home</a>
        <a href="leaderboard.php" class="btn btn-secondary">Visualizza Classifica</a>
        <a href="gioco.php" class="btn btn-success">Riprova</a>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <p>&copy; 2025 EnigmaMaster</p>
</footer>

</body>
</html>

<?php
// Chiudi la connessione al database
mysqli_close($conn);
?>
