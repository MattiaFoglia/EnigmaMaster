<?php
$host = "localhost";
$user = "root"; 
$password = ""; 
$dbname = "Enigmi";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>