<?php
session_start();
include 'config.php'; // Connessione al database

$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it'; // Usa la lingua della sessione, default è 'it'

include("lang/lang_$language.php");
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['game_info_title']; ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css"> 
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">EnigmaMaster</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? ' active' : '' ?>" href="index.php"><?php echo $lang['home']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="leaderboard.php"><?php echo $lang['leaderboard']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="info.php"><?php echo $lang['information']; ?></a>
                    </li>

                    <?php if (isset($_SESSION['utente_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><?php echo $lang['logout']; ?></a>
                        </li>
                    <?php else: ?>
                        <!-- Dropdown Login -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <?php echo $lang['login']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <form action="login.php" method="POST" class="px-4 py-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label"><?php echo $lang['login_email']; ?></label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label"><?php echo $lang['login_password']; ?></label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100"><?php echo $lang['login_button']; ?></button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="register.php"><?php echo $lang['register']; ?></a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Section -->
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo $lang['info_game_title']; ?></h1>
        <p class="lead">
            <?php echo $lang['game_description']; ?>
        </p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><?php echo $lang['game_rules_1']; ?></li>
            <li class="list-group-item"><?php echo $lang['game_rules_2']; ?></li>
            <li class="list-group-item"><?php echo $lang['game_rules_3']; ?></li>
            <li class="list-group-item"><?php echo $lang['game_rules_4']; ?></li>
        </ul>
        <p class="mt-4">
            <?php echo $lang['start_playing']; ?>
        </p>
    </div>

     <!-- Footer -->
     <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EnigmaMaster</p>
    </footer>

    <!-- Bootstrap JS e Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <?php
    mysqli_close($conn) or die("Errore chiusura connessione: " . mysqli_error($conn));
    ?>
</body>
</html>
