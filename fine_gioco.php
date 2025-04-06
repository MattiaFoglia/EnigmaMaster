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

    // Ottieni il punteggio attuale dell'utente
    $query = "SELECT punteggio FROM utenti WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $punteggio_attuale = $row['punteggio'];

            // Aggiorna solo se il nuovo punteggio è maggiore
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

// Pulisci la sessione
unset($_SESSION['question_count'], $_SESSION['total_score'], $_SESSION['enigma_api'], $_SESSION['tentativi']);
?>

<!DOCTYPE html>
<html lang="<?= $language ?>" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['game_over'] ?> - EnigmaMaster</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .result-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .result-card:hover {
            transform: translateY(-5px);
        }
        
        .score-display {
            font-size: 5rem;
            font-weight: 700;
            background: linear-gradient(90deg, #4e73df, #224abe);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .action-btn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            min-width: 180px;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include 'components/navbar.php'; ?>

    <main class="flex-grow-1 py-5">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="result-card card text-center p-4 p-md-5">
                        <div class="card-body">
                            <div class="mb-4">
                                <i class="bi bi-trophy-fill text-warning" style="font-size: 4rem;"></i>
                            </div>
                            <h1 class="display-4 fw-bold mb-3"><?= $lang['congratulations'] ?></h1>
                            <p class="lead fs-3 mb-4"><?= $lang['completed_game'] ?></p>
                            
                            <div class="my-4 py-3">
                                <p class="text-muted mb-2"><?= $lang['final_score'] ?></p>
                                <div class="score-display"><?= $punteggio ?></div>
                            </div>
                            
                            <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mt-4">
                                <a href="index.php" class="action-btn btn btn-primary">
                                    <i class="bi bi-house-door me-2"></i>
                                    <?= $lang['back_home_button'] ?>
                                </a>
                                <a href="leaderboard.php" class="action-btn btn btn-outline-secondary">
                                    <i class="bi bi-trophy me-2"></i>
                                    <?= $lang['view_leaderboard'] ?>
                                </a>
                                <a href="gioco.php" class="action-btn btn btn-success">
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

    <!-- Bootstrap 5.3 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Abilita i tooltip di Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>

<?php
// Chiudi la connessione al database
mysqli_close($conn);
?>