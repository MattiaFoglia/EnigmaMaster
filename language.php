<?php
session_start();
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if ($lang == 'it' || $lang == 'eng') {
        $_SESSION['lang'] = $lang;
    }
}
header("Location: index.php");
exit();
?>
