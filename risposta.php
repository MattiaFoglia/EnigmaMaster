<?php
/**
 * Gestisce la sottomissione della risposta e il punteggio
 * 
 * @package GameLogic
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.3.0
 * @link https://www.php.net/manual/en/function.preg-replace.php
 */
session_start();
require_once 'config.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
require_once "lang/lang_$language.php";

// Verifica la presenza dei dati nella richiesta POST
if (!isset($_POST['risposta'], $_POST['enigma_id'], $_SESSION['enigma_api'])) {
    $_SESSION['error'] = $lang['missing_data'];
    header("Location: gioco.php");
    exit();
}

// Verifica che l'ID dell'enigma corrisponda
if ($_POST['enigma_id'] !== $_SESSION['enigma_api']['id']) {
    $_SESSION['error'] = $lang['invalid_riddle'];
    header("Location: gioco.php");
    exit();
}

// Normalizza la risposta dell'utente e la risposta corretta
$user_answer = normalizeAnswer($_POST['risposta']);
$correct_answer = normalizeAnswer($_SESSION['enigma_api']['correct_answer']);

/**
 * Normalizza la stringa della risposta per un confronto corretto
 * 
 * @param string $answer La risposta da normalizzare
 * @return string La risposta normalizzata
 */
function normalizeAnswer($answer) {
    return preg_replace('/[^a-z0-9]/', '', strtolower(trim($answer)));
}

// Controlla se la risposta dell'utente è corretta
if ($user_answer === $correct_answer) {
    handleCorrectAnswer();
} else {
    handleWrongAnswer();
}

/**
 * Gestisce il caso di risposta corretta
 */
function handleCorrectAnswer() {
    global $conn, $lang;
    
    $points = 10; // Punteggio per la risposta corretta
    $_SESSION['total_score'] = ($_SESSION['total_score'] ?? 0) + $points; // Incrementa il punteggio totale dell'utente
    
    // Aggiornamento del punteggio nel database per utenti registrati
    if (isset($_SESSION['utente_id'])) {
        // Verifica se l'utente ha già un record nella leaderboard
        $stmt = $conn->prepare("SELECT punteggio FROM leaderboard WHERE utente_id = ?");
        $stmt->bind_param("i", $_SESSION['utente_id']);
        $stmt->execute();
        $stmt->store_result();

        // Se l'utente ha già un punteggio, aggiorna
        if ($stmt->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE leaderboard SET punteggio = GREATEST(punteggio, ?) WHERE utente_id = ?");
            $stmt->bind_param("ii", $_SESSION['total_score'], $_SESSION['utente_id']);
        } else {
            // Se l'utente non ha un record, inseriscilo
            $stmt = $conn->prepare("INSERT INTO leaderboard (utente_id, punteggio) VALUES (?, ?)");
            $stmt->bind_param("ii", $_SESSION['utente_id'], $_SESSION['total_score']);
        }

        if (!$stmt->execute()) {
            error_log("Errore aggiornamento punteggio: " . $conn->error);
        }
    }
    
    // Prepara un nuovo enigma per l'utente
    unset($_SESSION['enigma_api']);
    $_SESSION['success'] = $lang['congratulations'];
    header("Location: gioco.php?new=1");
    exit();
}

/**
 * Gestisce il caso di risposta errata
 */
function handleWrongAnswer() {
    global $lang;
    
    $_SESSION['tentativi']--; // Riduce i tentativi rimasti
    
    if ($_SESSION['tentativi'] <= 0) {
        // Game over: nessun tentativo rimasto
        $_SESSION['punteggio'] = $_SESSION['total_score'] ?? 0;
        unset($_SESSION['tentativi'], $_SESSION['enigma_api'], $_SESSION['question_count'], $_SESSION['total_score']);
        $_SESSION['game_over'] = true;
        header("Location: gameOver.php");
        exit();
    } else {
        // Tentativi rimasti
        $_SESSION['error'] = $lang['wrong_answer'];
        header("Location: gioco.php");
        exit();
    }
}
?>
