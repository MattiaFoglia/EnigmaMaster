<?php
session_start();
include 'config.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it'; // Usa la lingua della sessione, default è 'it'

include("lang/lang_$language.php");
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnigmaMaster</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">EnigmaMaster</a>
            <li class="navbar-nav ms-auto">
                <a href="language.php?lang=it" class="btn btn-light">Italiano</a>
                <a href="language.php?lang=eng" class="btn btn-light">English</a>
            </li>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? ' active' : '' ?>" href="index.php"><?= $lang['home'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="leaderboard.php"><?= $lang['leaderboard'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info.php"><?= $lang['information'] ?></a>
                    </li>

                    <?php if (isset($_SESSION['utente_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><?= $lang['logout'] ?></a>
                        </li>
                    <?php else: ?>
                        <!-- Dropdown Login -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $lang['login'] ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <form action="login.php" method="POST" class="px-4 py-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label"><?= $lang['login_email'] ?></label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label"><?= $lang['login_password'] ?></label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100"><?= $lang['login_button'] ?></button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="register.php"><?= $lang['register'] ?></a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Section -->
    <div class="container mt-5 text-center">
        <h1 class="display-4"><?= $lang['welcome'] ?></h1>
        <p class="lead"><?= $lang['challenge'] ?></p>

        <?php if (isset($_SESSION['utente_id'])): ?>
            <a href="gioco.php" class="btn btn-success btn-lg mt-3"><?= $lang['play_game'] ?></a>
        <?php else: ?>
            <a href="register.php" class="btn btn-primary btn-lg mt-3"><?= $lang['register_button'] ?></a>
            <a href="gioco.php" class="btn btn-success btn-lg mt-3"><?= $lang['guest_play'] ?></a>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EnigmaMaster</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <?php
    mysqli_close($conn) or die("Chiusura connessione fallita: " . mysqli_error($conn));
    ?>

</body>
</html>
