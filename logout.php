<?php
/**
 * Gestisce il logout dell'utente e salva il punteggio prima di terminare la sessione
 * 
 * @package Authentication
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.1.0
 * @link https://www.php.net/manual/en/function.session-destroy.php
 * @link https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php
 */
session_start();
include 'config.php';


if (isset($_SESSION['utente_id']) && isset($_SESSION['punteggio']) && $_SESSION['punteggio'] > 0) {
    $utente_id = $_SESSION['utente_id'];
    $punteggio = $_SESSION['punteggio'];

   $query = "UPDATE leaderboard SET punteggio = GREATEST(punteggio, ?) WHERE utente_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $punteggio, $utente_id);
    $stmt->execute();
    $stmt->close();
}

session_unset();
session_destroy();

header("Location: index.php");
exit();
?>
