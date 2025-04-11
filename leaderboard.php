<?php
/**
 * Pagina della classifica dei migliori giocatori
 * 
 * @package Views
 * @author Mattia Foglia
 * @since 2025-03-15
 * @version 1.3.0
 * @link https://getbootstrap.com/docs/5.3/content/tables/
 */
session_start();
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");
include 'config.php';
?>

<!DOCTYPE html>
<html lang="<?= $language ?>" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['leaderboard_title'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-dark text-light">
    <?php include 'components/navbar.php'; ?>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="card bg-dark border-primary shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">
                        <i class="bi bi-trophy me-2"></i>
                        <?= $lang['leaderboard_title'] ?>
                    </h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead>
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
                                        $highlight = isset($_SESSION['utente_id']) && $row['nome'] === $_SESSION['nome'] ? 'bg-primary bg-opacity-25' : '';
                                ?>
                                    <tr class="<?= $highlight ?>">
                                        <td>
                                            <?php if ($posizione <= 3): ?>
                                                <span class="badge bg-<?= 
                                                    $posizione === 1 ? 'gold' : 
                                                    ($posizione === 2 ? 'silver' : 'bronze')
                                                ?> me-2">
                                                    <?= $posizione ?>
                                                </span>
                                            <?php else: ?>
                                                <?= $posizione ?>
                                            <?php endif; ?>
                                        </td>
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
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>