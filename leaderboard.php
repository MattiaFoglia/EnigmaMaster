<?php
session_start();
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it'; // Usa la lingua della sessione, default è 'it'

include("lang/lang_$language.php");
include 'config.php'; // Connessione al database
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="UTF-8">
    <title><?= $lang['leaderboard_title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css"> 
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">EnigmaMaster</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? ' active' : '' ?>" href="index.php"><?= $lang['home'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="leaderboard.php"><?= $lang['leaderboard'] ?></a>
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
                                <li><a class="dropdown-item text-center" href="register.php"><?= $lang['register_button'] ?></a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Classifica -->
    <div class="container mt-5">
        <h2 class="mb-4"><?= $lang['leaderboard_title'] ?></h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?= $lang['position'] ?></th>
                    <th><?= $lang['player'] ?></th>
                    <th><?= $lang['score'] ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query per ottenere i 50 giocatori con il punteggio più alto
                $query = "SELECT nome, punteggio FROM utenti ORDER BY punteggio DESC LIMIT 50";
                $result = mysqli_query($conn, $query);
                $posizione = 1;

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Output della riga della classifica
                        echo "<tr>
                                <td>{$posizione}</td>
                                <td>" . htmlspecialchars($row['nome']) . "</td>
                                <td>{$row['punteggio']}</td>
                            </tr>";
                        $posizione++;
                    }
                } else {
                    echo "<tr><td colspan='3'>{$lang['no_data_available']}</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="text-white text-center py-3 mt-5">
        <p>&copy; 2025 EnigmaMaster</p>
    </footer>>

    <!-- Bootstrap JS e Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <?php
    mysqli_close($conn); // Chiudi la connessione al database
    ?>
</body>
</html>
