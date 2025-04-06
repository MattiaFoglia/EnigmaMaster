<?php
/**
 * Gestione del cambio lingua dell'applicazione
 * 
 * @package Core
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.0.0
 */
session_start();
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if ($lang == 'it' || $lang == 'eng') {
        $_SESSION['lang'] = $lang;
    }
}
header("Location: index.php");
exit();
?>
