<?php
session_start();
include 'config.php';

// Verifica se l'utente è loggato e admin
if (!isset($_SESSION['utente_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");
?>

<!DOCTYPE html>
<html lang="<?= $language ?>" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['admin_panel'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-dark text-light">
    <?php include 'components/navbar.php'; ?>

    <main class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4"><i class="bi bi-shield-lock me-2"></i><?= $lang['admin_panel'] ?></h1>
                
                <div class="card bg-dark border-primary mb-4">
                    <div class="card-header bg-primary">
                        <h3><?= $lang['user_management'] ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th><?= $lang['name'] ?></th>
                                        <th>Email</th>
                                        <th><?= $lang['score'] ?></th>
                                        <th>Admin</th>
                                        <th><?= $lang['actions'] ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users = $conn->query("SELECT id, nome, email, punteggio, is_admin FROM utenti ORDER BY id");
                                    while ($user = $users->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= htmlspecialchars($user['nome']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= $user['punteggio'] ?></td>
                                        <td><?= $user['is_admin'] ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>' ?></td>
                                        <td>
                                            <?php if ($user['id'] != $_SESSION['utente_id']): ?>
                                                <a href="admin_action.php?action=toggle_admin&user_id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-shield"></i> Toggle Admin
                                                </a>
                                                <a href="admin_action.php?action=delete&user_id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('<?= $lang['confirm_delete'] ?>')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Aggiungi qui altre sezioni per la gestione degli enigmi, ecc. -->
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>