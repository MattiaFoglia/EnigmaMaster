<?php

/**
 * Gestisce il processo di registrazione degli utenti
 * 
 * @package Authentication
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.2.0
 * @license MIT
 * @link https://www.php.net/manual/en/function.password-hash.php
 * @link https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php
 */
session_start();
require 'config.php';

// Debug attivato
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Controllo connessione database
if ($conn->connect_error) {
    die("Connessione DB fallita: " . $conn->connect_error);
}

$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
require "lang/lang_$language.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string(trim($_POST['nome']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    
    try {
        // Prima verifica: campi vuoti
        if (empty($nome) || empty($email) || empty($password)) {
            throw new Exception("Tutti i campi sono obbligatori");
        }

        // Seconda verifica: email esistente
        $check = $conn->query("SELECT id FROM utenti WHERE email = '$email'");
        if ($check->num_rows > 0) {
            throw new Exception("Email già registrata");
        }

        // Terza verifica: query di inserimento
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->query("INSERT INTO utenti (nome, email, password) VALUES ('$nome', '$email', '$hash')");
        
        if (!$insert) {
            throw new Exception("Errore DB: " . $conn->error);
        }

        $_SESSION['success'] = "Registrazione completata!";
        header("Location: login.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "ERRORE: " . $e->getMessage() . " | Query: " . $debug_query;
    }
}
?>

 <!DOCTYPE html>
 <html lang="<?= $language ?>" data-bs-theme="dark">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= $lang['register'] ?> - EnigmaMaster</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="./css/style.css">
 </head>
 <body class="d-flex flex-column min-vh-100 bg-dark text-light">
     <?php include 'components/navbar.php'; ?>
 
     <main class="flex-grow-1 d-flex align-items-center py-5">
         <div class="container">
             <div class="row justify-content-center">
                 <div class="col-md-8 col-lg-6 col-xl-5">
                     <div class="card bg-dark border-primary shadow-lg animate__animated animate__fadeIn">
                         <div class="card-header bg-primary text-white">
                             <h2 class="mb-0 text-center">
                                 <i class="bi bi-person-plus me-2"></i>
                                 <?= $lang['register'] ?>
                             </h2>
                         </div>
                         <div class="card-body p-4 p-md-5">
                             <?php if (isset($_SESSION['error'])): ?>
                                 <div class="alert alert-danger animate__animated animate__shakeX">
                                     <?= $_SESSION['error'] ?>
                                 </div>
                                 <?php unset($_SESSION['error']); ?>
                             <?php endif; ?>
 
                             <form method="POST" novalidate>
                                 <div class="mb-4">
                                     <label for="nome" class="form-label"><?= $lang['name'] ?></label>
                                     <input type="text" class="form-control bg-dark text-light border-secondary" 
                                            id="nome" name="nome" required
                                            value="<?= htmlspecialchars($nome ?? '') ?>">
                                 </div>
                                 <div class="mb-4">
                                     <label for="email" class="form-label"><?= $lang['email'] ?></label>
                                     <input type="email" class="form-control bg-dark text-light border-secondary" 
                                            id="email" name="email" required
                                            value="<?= htmlspecialchars($email ?? '') ?>">
                                 </div>
                                 <div class="mb-4">
                                     <label for="password" class="form-label"><?= $lang['password'] ?></label>
                                     <input type="password" class="form-control bg-dark text-light border-secondary" 
                                            id="password" name="password" required>
                                 </div>
                                 <button type="submit" class="btn btn-primary w-100 py-2">
                                     <i class="bi bi-person-plus me-2"></i>
                                     <?= $lang['register_button'] ?>
                                 </button>
                             </form>
 
                             <div class="mt-4 pt-3 text-center border-top border-secondary">
                                 <p class="mb-0"><?= $lang['already_registered'] ?>
                                     <a href="login.php" class="text-primary fw-bold">
                                         <?= $lang['login'] ?>
                                     </a>
                                 </p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </main>
 
     <?php include 'components/footer.php'; ?>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 </body>
 </html>
 <?php 
 if (isset($conn)) { 
     $conn->close(); 
 }
 ?>