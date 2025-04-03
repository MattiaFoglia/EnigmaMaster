<?php
session_start();
include 'config.php';

// Se la lingua è passata via GET, carica quella lingua (italiano predefinito)
$lang = isset($_GET['lang']) && $_GET['lang'] == 'en' ? 'en' : 'it';

// Se il metodo di richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prevenzione di SQL Injection
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verifica se l'email è già registrata
    $sql_check_email = "SELECT * FROM utenti WHERE email = '$email'";
    $result = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result) > 0) {
        $errore = $lang == 'en' ? "This email is already registered." : "Questa email è già registrata.";
    } else {
        // Inserimento del nuovo utente
        $sql = "INSERT INTO utenti (nome, email, password) VALUES ('$nome', '$email', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            // Reindirizza al login dopo registrazione riuscita
            header("Location: login.php?lang=$lang");
            exit();
        } else {
            $errore = $lang == 'en' ? "Error during registration: " . mysqli_error($conn) : "Errore durante la registrazione: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $lang; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang == 'en' ? 'Register - EnigmaMaster' : 'Registrati - EnigmaMaster'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2><?= $lang == 'en' ? 'Create an Account' : 'Crea un account'; ?></h2>

        <?php if (isset($errore)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($errore); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label"><?= $lang == 'en' ? 'Name' : 'Nome'; ?></label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><?= $lang == 'en' ? 'Email' : 'Email'; ?></label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><?= $lang == 'en' ? 'Password' : 'Password'; ?></label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success"><?= $lang == 'en' ? 'Register' : 'Registrati'; ?></button>
            <a href="login.php?lang=<?= $lang; ?>" class="btn btn-link"><?= $lang == 'en' ? 'Already have an account?' : 'Hai già un account?'; ?></a>
        </form>

        <div class="mt-3">
            <a href="?lang=it" class="btn btn-link">Italiano</a> | 
            <a href="?lang=en" class="btn btn-link">English</a>
        </div>
    </div>
</body>

</html>
