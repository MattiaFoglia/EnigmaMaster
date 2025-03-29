<?php
session_start();
include("config.php"); // Ensure the connection is initialized

// Load the language file
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it'; // Default to 'it' if not set
include("lang/lang_$language.php");

if (isset($_GET['id'])) {
    $id_enigma = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM enigmi WHERE id = ?");
    $stmt->bind_param("i", $id_enigma);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $stmt = $conn->prepare("SELECT * FROM enigmi WHERE NOW() BETWEEN data_inizio AND data_fine ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
}

if (!$result || $result->num_rows === 0) {
    echo $lang['no_enigma_available']; // Display the no enigma available message
    exit();
}

$enigma = $result->fetch_assoc();

// Initialize session variables for the current puzzle and attempts if necessary
if (!isset($_SESSION['enigma_corrente']) || $_SESSION['enigma_corrente'] !== $enigma['id']) {
    $_SESSION['tentativi'] = 3;
    $_SESSION['enigma_corrente'] = $enigma['id'];
}
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $lang['play_game_title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #suggerimento-box {
            display: none;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2><?= htmlspecialchars($enigma['titolo']) ?></h2>
    <p class="lead"><?= htmlspecialchars($enigma['descrizione']) ?></p>

    <?php if (isset($_GET['errore']) && $_GET['errore'] == 1): ?>
        <div class="alert alert-danger"><?= $lang['wrong_answer'] ?></div>
    <?php endif; ?>

    <p><strong><?= $lang['attempts_left'] ?>:</strong> <?= $_SESSION['tentativi'] ?? 3 ?></p>

    <form method="POST" action="risposta.php">
        <input type="hidden" name="id_enigma" value="<?= $enigma['id'] ?>">
        <div class="mb-3">
            <label for="risposta" class="form-label"><?= $lang['your_answer'] ?></label>
            <input type="text" class="form-control" id="risposta" name="risposta" required>
        </div>
        <button type="submit" class="btn btn-primary"><?= $lang['submit_button'] ?></button>
    </form>

    <!-- Button to show hint -->
    <button class="btn btn-secondary mt-3" onclick="mostraIndizio()"><?= $lang['show_hint'] ?></button>
    <div id="suggerimento-box" class="alert alert-info">
        <strong><?= $lang['hint'] ?></strong> <?= htmlspecialchars($enigma['suggerimento']) ?>
    </div>

    <hr>
    <p><?= $lang['score'] ?>: <strong><?= $_SESSION['punteggio'] ?? 0 ?></strong></p>
</div>

<script>
    function mostraIndizio() {
        document.getElementById('suggerimento-box').style.display = 'block';
    }
</script>
</body>
</html>
