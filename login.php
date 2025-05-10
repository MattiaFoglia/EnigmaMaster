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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, nome, email, password, punteggio, is_admin FROM utenti WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['utente_id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['punteggio'] = $row['punteggio'];
            $_SESSION['is_admin'] = (bool)$row['is_admin'];

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
<html lang="<?= $language ?>" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['login'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="d-flex flex-column min-vh-100 bg-dark text-light">
    <?php include 'components/navbar.php'; ?>

    <main class="flex-grow-1 d-flex align-items-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark border-primary shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h2 class="mb-0 text-center">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                <?= $lang['login'] ?>
                            </h2>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger">
                                    <?= $_SESSION['error'] ?>
                                </div>
                                <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>

                            <form method="POST">
                                <div class="mb-4">
                                    <label for="email" class="form-label"><?= $lang['login_email'] ?></label>
                                    <input type="email" class="form-control bg-dark text-light border-secondary" 
                                           id="email" name="email" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label"><?= $lang['login_password'] ?></label>
                                    <input type="password" class="form-control bg-dark text-light border-secondary" 
                                           id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <?= $lang['login_button'] ?>
                                </button>
                            </form>

                            <div class="mt-4 pt-3 text-center border-top border-secondary">
                                <p class="mb-0"><?= $lang['no_account'] ?>
                                    <a href="register.php" class="text-primary">
                                        <?= $lang['register'] ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>