<?php
session_start();
include 'config.php';
include 'api.php';
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it';
include("lang/lang_$language.php");

// Ottieni le categorie disponibili dall'API
$categories = ottieniCategorieAPI();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
    $_SESSION['categoria_selezionata'] = (int)$_POST['categoria'];
    $_SESSION['question_count'] = 0;
    $_SESSION['total_score'] = 0;
    header("Location: gioco.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['select_category'] ?> - EnigmaMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .category-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #dee2e6;
            height: 100%;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-color: var(--primary-color);
        }
        
        .category-radio {
            position: absolute;
            opacity: 0;
        }
        
        .category-radio:checked + .category-card {
            border-color: var(--primary-color);
            background-color: rgba(78, 115, 223, 0.05);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.2);
        }
        
        .category-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0 text-center"><?= $lang['select_category'] ?></h2>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="selezione_categoria.php">
                            <div class="row g-4">
                                <?php foreach ($categories as $id => $name): ?>
                                    <div class="col-md-4 col-sm-6">
                                        <input type="radio" 
                                               class="category-radio" 
                                               name="categoria" 
                                               id="categoria<?= $id ?>" 
                                               value="<?= $id ?>" 
                                               required>
                                        <label for="categoria<?= $id ?>">
                                            <div class="category-card card">
                                                <div class="card-body text-center p-4">
                                                    <div class="category-icon">
                                                        <?php 
                                                        // Icone diverse per categorie diverse
                                                        $icon = match(true) {
                                                            str_contains($name, 'Science') => 'bi bi-robot',
                                                            str_contains($name, 'Entertainment') => 'bi bi-film',
                                                            str_contains($name, 'Art') => 'bi bi-palette',
                                                            str_contains($name, 'History') => 'bi bi-hourglass',
                                                            default => 'bi bi-question-circle'
                                                        };
                                                        ?>
                                                        <i class="<?= $icon ?>"></i>
                                                    </div>
                                                    <h5 class="card-title fw-bold"><?= htmlspecialchars($name) ?></h5>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    <i class="bi bi-play-fill me-2"></i>
                                    <?= $lang['start_game'] ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Aggiunge feedback visivo alla selezione
        document.querySelectorAll('.category-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.category-card').forEach(card => {
                    card.classList.remove('border-primary', 'bg-primary', 'text-white');
                });
                
                if(this.checked) {
                    const card = this.nextElementSibling.querySelector('.category-card');
                    card.classList.add('border-primary');
                }
            });
        });
    </script>
</body>
</html>