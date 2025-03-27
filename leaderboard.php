<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">EnigmaMaster</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="leaderboard.php">Leaderboard</a></li>
                <li class="nav-item"><a class="nav-link" href="info.php">Informazioni</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Classifica -->
<div class="container mt-5">
    <h2 class="mb-4">Classifica Giocatori</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Posizione</th>
                <th>Giocatore</th>
                <th>Punteggio</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT nome, punteggio FROM utenti ORDER BY punteggio DESC LIMIT 50";
            $result = mysqli_query($conn, $query);
            $posizione = 1;

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$posizione}</td>
                        <td>" . htmlspecialchars($row['nome']) . "</td>
                        <td>{$row['punteggio']}</td>
                    </tr>";
                $posizione++;
            }
            ?>
        </tbody>
    </table>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    <p>&copy; 2025 EnigmaMaster</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<?php mysqli_close($conn); ?>
</body>
</html>
