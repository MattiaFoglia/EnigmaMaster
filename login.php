<?php
/**
 * Pagina di login per gli utenti registrati
 * 
 * @package Authentication
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.2.0
 * @link https://getbootstrap.com/docs/5.3/forms/overview/
 * @link https://www.php.net/manual/en/function.password-verify.php
 */
session_start();
include 'config.php';

if (isset($_SESSION['utente_id'])) {
    header("Location: index.php");
    exit();
}

$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");


/**
 * Processa il form di login quando inviato
 * 
 * @throws mysqli_sql_exception Se ci sono errori nel database
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, nome, email, password, punteggio FROM utenti WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['utente_id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['punteggio'] = $row['punteggio'];
            
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = $lang['wrong_password'];
        }
    } else {
        $_SESSION['error'] = $lang['user_not_found'];
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['login'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0"><?= $lang['login'] ?></h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['error'] ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label"><?= $lang['login_email'] ?></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"><?= $lang['login_password'] ?></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><?= $lang['login_button'] ?></button>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="register.php"><?= $lang['no_account'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>