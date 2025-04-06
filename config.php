<?php
/**
 * Configurazione del database per l'applicazione EnigmaMaster
 * 
 * @package Core
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.1.0
 * @link https://www.mysql.com/
 */

/**
 * @var string $host Host del database
 * @var string $user Nome utente del database
 * @var string $password Password del database
 * @var string $dbname Nome del database
 */
$host = "localhost";
$user = "root"; 
$password = ""; 
$dbname = "Enigmi";

/**
 * Connessione al database MySQL
 * 
 * @var mysqli $conn Oggetto di connessione al database
 */
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>