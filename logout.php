<?php
session_start();
include 'config.php';

if (isset($_SESSION['utente_id']) && isset($_SESSION['punteggio']) && $_SESSION['punteggio'] > 0) {
    $utente_id = $_SESSION['utente_id'];
    $punteggio = $_SESSION['punteggio'];

    // Salva il punteggio in una nuova tabella o in una colonna nella tabella utenti
    $query = "UPDATE utenti SET punteggio = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $punteggio, $utente_id);
    $stmt->execute();
    $stmt->close();
}

// Distruggi la sessione
session_unset();
session_destroy();

header("Location: index.php");
exit();
?>
