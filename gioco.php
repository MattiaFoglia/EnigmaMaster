<?php
session_start();
include 'config.php';
include 'api.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");

// Verifica che sia stata selezionata una categoria
if (!isset($_SESSION['categoria_selezionata'])) {
    header("Location: selezione_categoria.php");
    exit();
}

// Inizializza le variabili di sessione se non esistono
if (!isset($_SESSION['question_count'])) {
    $_SESSION['question_count'] = 0;
    $_SESSION['total_score'] = 0;
}

// Verifica e carica un nuovo enigma se necessario
if (!isset($_SESSION['enigma_api']) || isset($_GET['new'])) {
    // Se abbiamo completato 10 domande, reindirizza alla pagina di fine gioco
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

    // Costruisci la struttura dati corretta
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

// Verifica che la struttura dati sia completa
if (!isset($_SESSION['enigma_api']['question'], $_SESSION['enigma_api']['options'])) {
    unset($_SESSION['enigma_api']);
    $_SESSION['error'] = $lang['no_enigma_available'];
    header("Location: index.php");
    exit();
}

$enigma = $_SESSION['enigma_api'];
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['play_game_title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .option-item { 
            transition: all 0.2s; 
            cursor: pointer;
            padding: 12px 15px;
            margin-bottom: 8px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .option-item:hover { 
            background-color: #f8f9fa;
            border-color: #adb5bd;
        }
        .progress-container {
            margin-bottom: 20px;
        }
        .category-badge {
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Barra di progresso -->
        <div class="progress-container">
            <div class="d-flex justify-content-between mb-2">
                <span><?= $lang['question'] ?> <?= $_SESSION['question_count'] ?> / 10</span>
                <span><?= $lang['score'] ?>: <?= $_SESSION['total_score'] ?></span>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: <?= $_SESSION['question_count'] * 10 ?>%" 
                     aria-valuenow="<?= $_SESSION['question_count'] ?>" aria-valuemin="0" aria-valuemax="10"></div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3><?= $lang['play_game_title'] ?></h3>
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            <?= $lang['attempts_left'] ?>: <?= $_SESSION['tentativi'] ?>
                        </span>
                        <span class="badge bg-secondary category-badge">
                            <?= $lang['category'] ?>: <?= htmlspecialchars($enigma['category']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Domanda -->
                <div class="mb-4 p-3 bg-white rounded border">
                    <h4 class="mb-3"><?= htmlspecialchars($enigma['question']) ?></h4>
                    <div class="d-flex gap-2 mb-2">
                        <span class="badge bg-info"><?= ucfirst(htmlspecialchars($enigma['difficulty'])) ?></span>
                    </div>
                    <p class="mb-0 text-muted"><?= $lang['select_answer'] ?></p>
                </div>

                <!-- Opzioni di risposta -->
                <form method="POST" action="risposta.php">
                    <input type="hidden" name="enigma_id" value="<?= $enigma['id'] ?>">
                    
                    <div class="mb-4">
                        <?php foreach ($enigma['options'] as $index => $option): ?>
                            <div class="option-item">
                                <input class="form-check-input me-2" 
                                       type="radio" 
                                       name="risposta" 
                                       id="option<?= $index ?>" 
                                       value="<?= htmlspecialchars($option) ?>" 
                                       required>
                                <label class="form-check-label" for="option<?= $index ?>">
                                    <?= htmlspecialchars($option) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <?= $lang['submit_button'] ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>