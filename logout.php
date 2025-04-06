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

/**
 * Salva il punteggio dell'utente se presente e valido
 * 
 * @var int|null $utente_id ID dell'utente dalla sessione
 * @var int|null $punteggio Punteggio corrente dalla sessione
 * 
 * @throws mysqli_sql_exception Se ci sono errori nel database
 */
if (isset($_SESSION['utente_id']) && isset($_SESSION['punteggio']) && $_SESSION['punteggio'] > 0) {
    $utente_id = $_SESSION['utente_id'];
    $punteggio = $_SESSION['punteggio'];

    
    /**
     * Query per aggiornare il punteggio dell'utente
     * @var string $query Query SQL preparata
     * @var mysqli_stmt $stmt Statement preparato
     */
    $query = "UPDATE utenti SET punteggio = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $punteggio, $utente_id);
    $stmt->execute();
    $stmt->close();
}

/**
 * Termina la sessione corrente
 * 
 * @uses session_unset() Rimuove tutte le variabili di sessione
 * @uses session_destroy() Distrugge completamente la sessione
 */
session_unset();
session_destroy();

header("Location: index.php");
exit();
?>
