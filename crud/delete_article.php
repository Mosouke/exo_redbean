<?php
require_once '../connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $article = R::load('articles', $_GET['id']);
    if ($article->id != 0) {
        R::trash($article);
    }
}

header('Location: listpost.php');
exit;
?>
