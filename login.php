<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $sql = "SELECT * FROM utenti WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['utente_id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            header("Location: index.php");
            $query = "SELECT id, nome, punteggio FROM utenti WHERE email = ? AND password = ?";
            $stmt = $connessione->prepare($query);
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $_SESSION['utente_id'] = $row['id'];
                $_SESSION['nome'] = $row['nome'];
                $_SESSION['punteggio'] = $row['punteggio']; // Riprende punteggio
                header("Location: index.php");
                exit();
            }
        } else {
            $errore = "Password errata.";
        }
    } else {
        $errore = "Utente non trovato.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Accedi a EnigmaMaster</h2>
    <?php if (isset($errore)) echo "<div class='alert alert-danger'>$errore</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-dark">Login</button>
        <a href="register.php" class="btn btn-link">Registrati</a>
    </form>
</div>
</body>
</html>
