<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informazioni - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leaderboard.php">Leaderboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="info.php">Informazioni</a>
                </li>

                <?php if (isset($_SESSION['utente_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <!-- Dropdown Login -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Accedi
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="login.php" method="POST" class="px-4 py-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Accedi</button>
                                </form>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="register.php">Registrati</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Section -->
<div class="container mt-5">
    <h1 class="mb-4">Informazioni sul gioco</h1>
    <p class="lead">
        <strong>EnigmaMaster</strong> è un gioco di logica e deduzione in cui i giocatori devono risolvere una serie di enigmi a difficoltà crescente.
    </p>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">Ogni livello presenta un enigma unico con tempo limitato per risolverlo.</li>
        <li class="list-group-item">Accumula punti per ogni risposta corretta e scala la classifica!</li>
        <li class="list-group-item">Puoi giocare come ospite, ma solo gli utenti registrati possono salvare i progressi e competere nella leaderboard.</li>
        <li class="list-group-item">Nuovi enigmi vengono aggiunti regolarmente per mantenere la sfida sempre attiva.</li>
    </ul>
    <p class="mt-4">
        Per iniziare a giocare, torna alla <a href="index.php">pagina principale</a> o <a href="register.php">registrati</a> subito!
    </p>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <p>&copy; 2025 EnigmaMaster</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<?php
mysqli_close($conn) or die("Errore chiusura connessione: " . mysqli_error($conn));
?>
</body>
</html>
