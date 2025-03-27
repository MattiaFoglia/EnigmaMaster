<?php
session_start();
include 'config.php';

if (!isset($_POST['id_enigma'], $_POST['risposta'])) {
    die("Dati mancanti.");
}

$id_enigma = (int) $_POST['id_enigma'];
$risposta_utente = strtolower(trim($_POST['risposta']));

// Recupera risposta corretta
$stmt = $conn->prepare("SELECT risposta_corretta FROM enigmi WHERE id = ?");
$stmt->bind_param("i", $id_enigma);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Enigma non trovato.");
}

$row = $result->fetch_assoc();
$risposta_corretta = strtolower(trim($row['risposta_corretta']));

// Imposta i tentativi solo se è la prima volta con questo enigma
if (!isset($_SESSION['enigma_corrente']) || $_SESSION['enigma_corrente'] != $id_enigma) {
    $_SESSION['enigma_corrente'] = $id_enigma;
    $_SESSION['tentativi'] = 3;
}

// === RISPOSTA CORRETTA ===
if ($risposta_utente === $risposta_corretta) {
    $_SESSION['punteggio'] = isset($_SESSION['punteggio']) ? $_SESSION['punteggio'] + 1 : 1;

    // Aggiorna DB se loggato
    if (isset($_SESSION['utente_id'])) {
        $stmt = $conn->prepare("UPDATE utenti SET punteggio = ? WHERE id = ?");
        $stmt->bind_param("ii", $_SESSION['punteggio'], $_SESSION['utente_id']);
        $stmt->execute();
    }

    // Reset per il prossimo enigma
    unset($_SESSION['tentativi']);
    unset($_SESSION['enigma_corrente']);

    // Trova prossimo enigma
    $stmt = $conn->prepare("SELECT id FROM enigmi WHERE id > ? ORDER BY id ASC LIMIT 1");
    $stmt->bind_param("i", $id_enigma);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $next = $result->fetch_assoc();
        header("Location: gioco.php?id=" . $next['id']);
    } else {
        header("Location: fine_gioco.php");
    }
    exit();
}

// === RISPOSTA SBAGLIATA ===
$_SESSION['tentativi']--;

if ($_SESSION['tentativi'] <= 0) {
    $_SESSION['punteggio'] = 0;

    if (isset($_SESSION['utente_id'])) {
        $stmt = $conn->prepare("UPDATE utenti SET punteggio = 0 WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['utente_id']);
        $stmt->execute();
    }

    unset($_SESSION['tentativi']);
    unset($_SESSION['enigma_corrente']);

    header("Location: gameOver.php");
    exit();
} else {
    // Resta sullo stesso enigma
    header("Location: gioco.php?id=" . $id_enigma . "&errore=1&tentativi=" . $_SESSION['tentativi']);
    exit();
}
?>
