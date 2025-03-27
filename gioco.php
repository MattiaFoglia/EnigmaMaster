<?php
session_start();
include 'config.php';

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
    echo "Nessun enigma disponibile al momento.";
    exit();
}

$enigma = $result->fetch_assoc();

if (!isset($_SESSION['enigma_corrente']) || $_SESSION['enigma_corrente'] !== $enigma['id']) {
    $_SESSION['tentativi'] = 3;
    $_SESSION['enigma_corrente'] = $enigma['id'];
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gioca - EnigmaMaster</title>
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
    <h2><?php echo htmlspecialchars($enigma['titolo']); ?></h2>
    <p class="lead"><?php echo htmlspecialchars($enigma['descrizione']); ?></p>

    <?php if (isset($_GET['errore']) && $_GET['errore'] == 1): ?>
        <div class="alert alert-danger">Risposta errata. Riprova!</div>
    <?php endif; ?>

    <p><strong>Tentativi rimasti:</strong> <?php echo $_SESSION['tentativi'] ?? 3; ?></p>

    <form method="POST" action="risposta.php">
        <input type="hidden" name="id_enigma" value="<?php echo $enigma['id']; ?>">
        <div class="mb-3">
            <label for="risposta" class="form-label">La tua risposta</label>
            <input type="text" class="form-control" id="risposta" name="risposta" required>
        </div>
        <button type="submit" class="btn btn-primary">Invia</button>
    </form>

    <!-- Bottone per mostrare suggerimento -->
    <button class="btn btn-secondary mt-3" onclick="mostraIndizio()">Mostra Indizio</button>
    <div id="suggerimento-box" class="alert alert-info">
        <strong>Indizio:</strong> <?php echo htmlspecialchars($enigma['suggerimento']); ?>
    </div>

    <hr>
    <p>Punteggio attuale: <strong><?php echo $_SESSION['punteggio'] ?? 0; ?></strong></p>
</div>

<script>
    function mostraIndizio() {
        document.getElementById('suggerimento-box').style.display = 'block';
    }
</script>
</body>
</html>
