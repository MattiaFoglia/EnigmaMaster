<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>EnigmaMaster</h5>
                <p class="mb-0"><?= $lang['game_description'] ?></p>
            </div>
            <div class="col-md-3">
                <h5><?= $lang['links'] ?></h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-white"><?= $lang['home'] ?></a></li>
                    <li><a href="leaderboard.php" class="text-white"><?= $lang['leaderboard'] ?></a></li>
                    <li><a href="info.php" class="text-white"><?= $lang['information'] ?></a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5><?= $lang['language'] ?></h5>
                <div class="btn-group">
                    <a href="language.php?lang=it" class="btn btn-sm btn-outline-light <?= $_SESSION['lang'] === 'it' ? 'active' : '' ?>">Italiano</a>
                    <a href="language.php?lang=eng" class="btn btn-sm btn-outline-light <?= $_SESSION['lang'] === 'eng' ? 'active' : '' ?>">English</a>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            <p class="mb-0">&copy; 2025 EnigmaMaster. <?= $lang['all_rights_reserved'] ?></p>
        </div>
    </div>
</footer>