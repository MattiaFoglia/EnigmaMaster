<?php
/**
 * Pagina principale di gioco con le domande
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.3.0
 * @link https://getbootstrap.com/docs/5.3/forms/overview/
 */

 session_start();
 include 'config.php';
 include 'api.php';
 $language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
 include("lang/lang_$language.php");
 
 if (!isset($_SESSION['categoria_selezionata'])) {
     header("Location: selezione_categoria.php");
     exit();
 }
 
 if (!isset($_SESSION['question_count'])) {
     $_SESSION['question_count'] = 0;
     $_SESSION['total_score'] = 0;
 }
 
 if (!isset($_SESSION['enigma_api']) || isset($_GET['new'])) {
     if ($_SESSION['question_count'] >= 10) {
         $_SESSION['game_completed'] = true;
         $_SESSION['punteggio'] = $_SESSION['total_score'];
         unset($_SESSION['categoria_selezionata']);
         header("Location: fine_gioco.php");
         exit();
     }
 
     $api_enigma = ottieniEnigmaAPI($_SESSION['categoria_selezionata']);
     
     if (!$api_enigma || !isset($api_enigma['question'], $api_enigma['correct_answer'], $api_enigma['incorrect_answers'])) {
         $_SESSION['error'] = $lang['no_enigma_available'];
         header("Location: index.php");
         exit();
     }
 
     $_SESSION['enigma_api'] = [
         'id' => 'api_'.uniqid(),
         'question' => htmlspecialchars_decode($api_enigma['question']),
         'correct_answer' => $api_enigma['correct_answer'],
         'options' => array_merge([$api_enigma['correct_answer']], $api_enigma['incorrect_answers']),
         'difficulty' => $api_enigma['difficulty'] ?? 'unknown',
         'category' => $api_enigma['category'] ?? 'General Knowledge'
     ];
     shuffle($_SESSION['enigma_api']['options']);
     
     $_SESSION['tentativi'] = 3;
     $_SESSION['question_count']++;
 }
 
 if (!isset($_SESSION['enigma_api']['question'], $_SESSION['enigma_api']['options'])) {
     unset($_SESSION['enigma_api']);
     $_SESSION['error'] = $lang['no_enigma_available'];
     header("Location: index.php");
     exit();
 }
 
 $enigma = $_SESSION['enigma_api'];
 ?>
 
 <!DOCTYPE html>
 <html lang="<?= $language ?>" data-bs-theme="dark">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= $lang['play_game_title'] ?> - EnigmaMaster</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
     <link rel="stylesheet" href="./css/style.css">
 </head>
 <body class="d-flex flex-column min-vh-100 bg-dark text-light">
     <?php include 'components/navbar.php'; ?>
 
     <main class="flex-grow-1 py-5">
         <div class="container">
             <?php if (isset($_SESSION['error'])): ?>
                 <div class="alert alert-danger alert-dismissible fade show">
                     <?= $_SESSION['error'] ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                 </div>
                 <?php unset($_SESSION['error']); ?>
             <?php endif; ?>
 
             <!-- Progress Bar -->
             <div class="mb-4">
                 <div class="d-flex justify-content-between mb-2">
                     <span><?= $lang['question'] ?> <?= $_SESSION['question_count'] ?> / 10</span>
                     <span class="badge bg-primary"><?= $lang['score'] ?>: <?= $_SESSION['total_score'] ?></span>
                 </div>
                 <div class="progress bg-dark" style="height: 10px;">
                     <div class="progress-bar bg-primary" role="progressbar" 
                          style="width: <?= $_SESSION['question_count'] * 10 ?>%" 
                          aria-valuenow="<?= $_SESSION['question_count'] ?>" 
                          aria-valuemin="0" 
                          aria-valuemax="10"></div>
                 </div>
             </div>
 
             <!-- Game Card -->
             <div class="card bg-dark border-primary shadow-lg">
                 <div class="card-header bg-primary text-white">
                     <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                         <h3 class="mb-0"><i class="bi bi-question-circle me-2"></i><?= $lang['play_game_title'] ?></h3>
                         <div class="d-flex gap-2">
                             <span class="badge bg-warning text-dark">
                                 <i class="bi bi-lightning-charge-fill me-1"></i>
                                 <?= $lang['attempts_left'] ?>: <?= $_SESSION['tentativi'] ?>
                             </span>
                             <span class="badge bg-secondary">
                                 <i class="bi bi-tag-fill me-1"></i>
                                 <?= htmlspecialchars($enigma['category']) ?>
                             </span>
                         </div>
                     </div>
                 </div>
 
                 <div class="card-body">

                 <div class="mb-4 p-4 bg-dark border border-secondary rounded">
                         <h4 class="mb-3"><?= htmlspecialchars($enigma['question']) ?></h4>
                         <span class="badge bg-<?= 
                             $enigma['difficulty'] === 'hard' ? 'danger' : 
                             ($enigma['difficulty'] === 'medium' ? 'warning' : 'success') 
                         ?>">
                             <?= ucfirst(htmlspecialchars($enigma['difficulty'])) ?>
                         </span>
                         <p class="mt-2 text-muted"><i class="bi bi-info-circle me-1"></i><?= $lang['select_answer'] ?></p>
                     </div>
 
                     <form method="POST" action="risposta.php">
                         <input type="hidden" name="enigma_id" value="<?= $enigma['id'] ?>">
                         
                         <div class="mb-4">
                             <?php foreach ($enigma['options'] as $index => $option): ?>
                                 <div class="form-check mb-3 p-3 bg-dark border border-secondary rounded hover-highlight">
                                     <input class="form-check-input" 
                                            type="radio" 
                                            name="risposta" 
                                            id="option<?= $index ?>" 
                                            value="<?= htmlspecialchars($option) ?>" 
                                            required>
                                     <label class="form-check-label ms-3" for="option<?= $index ?>">
                                         <?= htmlspecialchars($option) ?>
                                     </label>
                                 </div>
                             <?php endforeach; ?>
                         </div>
 
                         <div class="d-grid">
                             <button type="submit" class="btn btn-primary btn-lg py-3">
                                 <i class="bi bi-send-check me-2"></i>
                                 <?= $lang['submit_button'] ?>
                             </button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </main>
 
     <?php include 'components/footer.php'; ?>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 </body>
 </html>