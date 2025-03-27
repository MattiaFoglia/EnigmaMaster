<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO utenti (nome, email, password) VALUES ('$nome', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        $errore = "Errore durante la registrazione: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrati - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Crea un account</h2>
    <?php if (isset($errore)) echo "<div class='alert alert-danger'>$errore</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Registrati</button>
        <a href="login.php" class="btn btn-link">Hai già un account?</a>
    </form>
</div>
</body>
</html>
