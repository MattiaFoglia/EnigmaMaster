<?php
/**
 * Handles answer submission and scoring
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

if (!isset($_POST['risposta'], $_POST['enigma_id'], $_SESSION['enigma_api'])) {
    $_SESSION['error'] = $lang['missing_data'];
    header("Location: gioco.php");
    exit();
}

if ($_POST['enigma_id'] !== $_SESSION['enigma_api']['id']) {
    $_SESSION['error'] = $lang['invalid_riddle'];
    header("Location: gioco.php");
    exit();
}

$user_answer = normalizeAnswer($_POST['risposta']);
$correct_answer = normalizeAnswer($_SESSION['enigma_api']['correct_answer']);

/**
 * Normalizes answer strings for comparison
 * 
 * @param string $answer The answer to normalize
 * @return string Normalized answer
 */
function normalizeAnswer($answer) {
    return preg_replace('/[^a-z0-9]/', '', strtolower(trim($answer)));
}

if ($user_answer === $correct_answer) {
    handleCorrectAnswer();
} else {
    handleWrongAnswer();
}

/**
 * Handles wrong answer scenario
 */
function handleCorrectAnswer() {
    global $conn, $lang;
    
    $points = 10;
    $_SESSION['total_score'] = ($_SESSION['total_score'] ?? 0) + $points;
    
    // Aggiornamento DB per utenti registrati
    if (isset($_SESSION['utente_id'])) {
        $stmt = $conn->prepare("UPDATE utenti SET punteggio = GREATEST(punteggio, ?) WHERE id = ?");
        $stmt->bind_param("ii", $_SESSION['total_score'], $_SESSION['utente_id']);
        
        if (!$stmt->execute()) {
            error_log("Errore aggiornamento punteggio: " . $conn->error);
        }
    }
    
    // Prepara nuovo enigma
    unset($_SESSION['enigma_api']);
    $_SESSION['success'] = $lang['congratulations'];
    header("Location: gioco.php?new=1");
    exit();
}

// Gestione risposta errata
function handleWrongAnswer() {
    global $lang;
    
    $_SESSION['tentativi']--;
    
    if ($_SESSION['tentativi'] <= 0) {
        // Game over
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