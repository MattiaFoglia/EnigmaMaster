<?php
/**
 * Pagina della classifica dei migliori giocatori
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.2.0
 * @link https://getbootstrap.com/docs/5.3/content/tables/
 */
session_start();
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");
include 'config.php';
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $lang['leaderboard_title'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <main class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0"><?= $lang['leaderboard_title'] ?></h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="15%"><?= $lang['position'] ?></th>
                                <th><?= $lang['player'] ?></th>
                                <th width="20%"><?= $lang['score'] ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT nome, punteggio FROM utenti ORDER BY punteggio DESC LIMIT 50";
                            $result = mysqli_query($conn, $query);
                            $posizione = 1;

                            if ($result && mysqli_num_rows($result) > 0):
                                while ($row = mysqli_fetch_assoc($result)):
                                    $highlight = isset($_SESSION['utente_id']) && $row['nome'] === $_SESSION['nome'] ? 'table-info' : '';
                            ?>
                                <tr class="<?= $highlight ?>">
                                    <td><?= $posizione ?></td>
                                    <td><?= htmlspecialchars($row['nome']) ?></td>
                                    <td><?= $row['punteggio'] ?></td>
                                </tr>
                            <?php
                                    $posizione++;
                                endwhile;
                            else:
                            ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4"><?= $lang['no_data_available'] ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>