<?php
/**
 * Pagina di fine gioco con risultati finali
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.2.0
 * @link https://getbootstrap.com/docs/5.3/components/card/
 */

 session_start();
 include 'config.php';
 $language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
 include("lang/lang_$language.php");
 
 $punteggio = $_SESSION['punteggio'] ?? 0;
 
 if (isset($_SESSION['utente_id']) && isset($_SESSION['punteggio'])) {
     $id = $_SESSION['utente_id'];
     $punteggio_nuovo = intval($_SESSION['punteggio']);
 
     $query = "SELECT l.punteggio 
          FROM leaderboard l 
          INNER JOIN utenti u ON l.utente_id = u.id 
          WHERE u.id = ?";
     if ($stmt = mysqli_prepare($conn, $query)) {
         mysqli_stmt_bind_param($stmt, 'i', $id);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
 
         if ($row = mysqli_fetch_assoc($result)) {
             $punteggio_attuale = $row['punteggio'];
             if ($punteggio_nuovo > $punteggio_attuale) {
                 $update = "UPDATE utenti SET punteggio = ? WHERE id = ?";
                 if ($stmt_update = mysqli_prepare($conn, $update)) {
                     mysqli_stmt_bind_param($stmt_update, 'ii', $punteggio_nuovo, $id);
                     mysqli_stmt_execute($stmt_update);
                 }
             }
         }
         mysqli_stmt_close($stmt);
     }
 }
 
 unset($_SESSION['question_count'], $_SESSION['total_score'], $_SESSION['enigma_api'], $_SESSION['tentativi']);
 ?>
 
 <!DOCTYPE html>
 <html lang="<?= $language ?>" data-bs-theme="dark">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= $lang['game_over'] ?> - EnigmaMaster</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
     <link rel="stylesheet" href="./css/style.css">
 </head>
 <body class="d-flex flex-column min-vh-100 bg-dark text-light">
     <?php include 'components/navbar.php'; ?>
 
     <main class="flex-grow-1 d-flex align-items-center py-5">
         <div class="container">
             <div class="row justify-content-center">
                 <div class="col-lg-8 col-xl-6">
                     <div class="card bg-dark border-primary shadow-lg">
                         <div class="card-body p-4 p-md-5 text-center">
                             <div class="mb-4">
                                 <i class="bi bi-trophy-fill text-warning display-3"></i>
                             </div>
                             <h1 class="display-5 fw-bold mb-3"><?= $lang['congratulations'] ?></h1>
                             <p class="lead mb-4"><?= $lang['completed_game'] ?></p>
                             
                             <div class="my-4 py-3 border-top border-bottom border-secondary">
                                 <p class="text-muted mb-2"><?= $lang['final_score'] ?></p>
                                 <div class="display-4 fw-bold text-primary"><?= $punteggio ?></div>
                             </div>
                             
                             <div class="d-grid gap-3 mt-4">
                                 <a href="index.php" class="btn btn-primary btn-lg py-3">
                                     <i class="bi bi-house-door me-2"></i>
                                     <?= $lang['back_home_button'] ?>
                                 </a>
                                 <a href="leaderboard.php" class="btn btn-outline-primary btn-lg py-3">
                                     <i class="bi bi-trophy me-2"></i>
                                     <?= $lang['view_leaderboard'] ?>
                                 </a>
                                 <a href="selezione_categoria.php" class="btn btn-success btn-lg py-3">
                                     <i class="bi bi-arrow-repeat me-2"></i>
                                     <?= $lang['play_again'] ?>
                                 </a>
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
 <?php mysqli_close($conn); ?>