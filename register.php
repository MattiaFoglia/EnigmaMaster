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
 include 'config.php';
 
 $language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
 include("lang/lang_$language.php");
 
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $nome = mysqli_real_escape_string($conn, $_POST['nome']);
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
     $stmt = $conn->prepare("SELECT id FROM utenti WHERE email = ?");
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $result = $stmt->get_result();
 
     if ($result->num_rows > 0) {
         $_SESSION['error'] = $lang['email_exists'];
     } else {
         $stmt = $conn->prepare("INSERT INTO utenti (nome, email, password) VALUES (?, ?, ?)");
         $stmt->bind_param("sss", $nome, $email, $password);
         
         if ($stmt->execute()) {
             $_SESSION['success'] = $lang['registration_success'];
             header("Location: login.php");
             exit();
         } else {
             $_SESSION['error'] = $lang['registration_error'];
         }
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
     <link rel="stylesheet" href="./css/style.css">
 </head>
 <body class="d-flex flex-column min-vh-100 bg-dark text-light">
     <?php include 'components/navbar.php'; ?>
 
     <main class="flex-grow-1 d-flex align-items-center py-5">
         <div class="container">
             <div class="row justify-content-center">
                 <div class="col-md-8 col-lg-6 col-xl-5">
                     <div class="card bg-dark border-primary shadow-lg">
                         <div class="card-header bg-primary text-white">
                             <h2 class="mb-0 text-center">
                                 <i class="bi bi-person-plus me-2"></i>
                                 <?= $lang['register'] ?>
                             </h2>
                         </div>
                         <div class="card-body p-4 p-md-5">
                             <?php if (isset($_SESSION['error'])): ?>
                                 <div class="alert alert-danger">
                                     <?= $_SESSION['error'] ?>
                                 </div>
                                 <?php unset($_SESSION['error']); ?>
                             <?php endif; ?>
 
                             <form method="POST">
                                 <div class="mb-4">
                                     <label for="nome" class="form-label"><?= $lang['name'] ?></label>
                                     <input type="text" class="form-control bg-dark text-light border-secondary" 
                                            id="nome" name="nome" required>
                                 </div>
                                 <div class="mb-4">
                                     <label for="email" class="form-label"><?= $lang['email'] ?></label>
                                     <input type="email" class="form-control bg-dark text-light border-secondary" 
                                            id="email" name="email" required>
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
                                     <a href="login.php" class="text-primary">
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
 <?php $conn->close(); ?>