<?php
    require_once '../connect.php';
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: ./login.php');
        exit;
    }

    $message = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $articles = R::dispense('articles');
        $articles->title_article = $_POST['title_article'];
        $articles->content_article = $_POST['content_article'];
        $articles->created = date('d-m-Y H-i-s');

        if (empty($articles->title_article) || empty('$articles->content_article')) {
            $message = '<p class="error">Veuillez remplire tout les champs.</p>';
        } else {
            $id = R::store($articles);
            $message = '<p class="success">Article ajouté avec successé.</p>';
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Créer un article</title>
</head>
<body>
    <div class="container">
        <h1>Créer un article</h1>
        <?= $message ?>
        <form method="post" action="#">
            <label for="title_article">Titre :</label>
            <input type="text" name="title_article" id="title_article" required>
            <label for="content_article">Contenu :</label>
            <textarea name="content_article" id="content_article" required></textarea>
            <button type="submit">Créer</button>
        </form>
        <a href="listpost.php">Retour au tableau de bord</a>
    </div>
</body>
</html>