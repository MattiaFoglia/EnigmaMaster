<?php
include 'config.php';

// Verifica delle credenziali
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepara la query per verificare l'email
    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // "s" sta per stringa (email)
    $stmt->execute();
    $result = $stmt->get_result();

    // Se l'utente esiste
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifica della password
        if ($password == $user['password']) {  // In un'applicazione reale dovresti usare password_hash() e password_verify()
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $user['email'];
            header('Location: dashboard.php'); // Redirect alla pagina successiva
            exit();
        } else {
            $error_message = "Password errata!";
        }
    } else {
        $error_message = "Email non trovata!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EnigmaMaster</title>
    <!-- Link a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">EnigmaMaster</a>
        </div>
    </nav>

    <!-- Form di login -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Accedi al tuo account</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($error_message)) {
                            echo "<div class='alert alert-danger'>$error_message</div>";
                        }
                        ?>
                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Accedi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Link a Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    mysqli_close ($connessione)
    or die("Chiusura connessione fallita " . mysqli_error ($connessione));
?>