<?php
session_start();
include 'config.php'; // Connessione al database

// Controllo se l'utente è già loggato
if (isset($_SESSION['utente_id'])) {
    header("Location: index.php"); // Se già loggato, redirigi alla home
    exit();
}

// Se il metodo di richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prevenzione di SQL Injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query per cercare l'utente con l'email fornita
    $sql = "SELECT * FROM utenti WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verifica della password
        if (password_verify($password, $row['password'])) {
            // Impostazione delle variabili di sessione
            $_SESSION['utente_id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['punteggio'] = $row['punteggio']; // Riprendi punteggio

            // Redirect alla home page
            header("Location: index.php");
            exit();
        } else {
            // Se la password è errata
            $errore = "Password errata. Riprova.";
        }
    } else {
        // Se l'utente non è trovato
        $errore = "Utente non trovato. Assicurati di aver inserito l'email correttamente.";
    }
}

// Se la lingua è passata via GET, carica quella lingua (italiano predefinito)
$lang = isset($_GET['lang']) && $_GET['lang'] == 'en' ? 'en' : 'it';
?>

<!DOCTYPE html>
<html lang="<?= $lang; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang == 'en' ? 'Login to EnigmaMaster' : 'Accedi a EnigmaMaster'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2><?= $lang == 'en' ? 'Login to EnigmaMaster' : 'Accedi a EnigmaMaster'; ?></h2>

        <?php if (isset($errore)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($errore); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label"><?= $lang == 'en' ? 'Email' : 'Email'; ?></label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><?= $lang == 'en' ? 'Password' : 'Password'; ?></label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-dark"><?= $lang == 'en' ? 'Login' : 'Login'; ?></button>
            <a href="register.php" class="btn btn-link"><?= $lang == 'en' ? 'Register' : 'Registrati'; ?></a>
        </form>

        <div class="mt-3">
            <a href="?lang=it" class="btn btn-link">Italiano</a> | 
            <a href="?lang=en" class="btn btn-link">English</a>
        </div>
    </div>
</body>

</html>
