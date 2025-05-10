<?php
session_start();
include 'config.php';

// Verifica se l'utente è loggato e admin
if (!isset($_SESSION['utente_id'])){
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

$action = $_GET['action'] ?? '';
$user_id = intval($_GET['user_id'] ?? 0);

switch ($action) {
    case 'toggle_admin':
        // Ottieni lo stato attuale
        $stmt = $conn->prepare("SELECT is_admin FROM utenti WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        // Inverti lo stato
        $new_status = $user['is_admin'] ? 0 : 1;
        $stmt = $conn->prepare("UPDATE utenti SET is_admin = ? WHERE id = ?");
        $stmt->bind_param("ii", $new_status, $user_id);
        $stmt->execute();
        break;
        
    case 'delete':
        $stmt = $conn->prepare("DELETE FROM utenti WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        break;
}

header("Location: admin.php");
exit();
?>