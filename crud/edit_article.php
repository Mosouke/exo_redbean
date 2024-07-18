<?php
    require_once '../connect.php';
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    
    if (!isset($_GET['id'])) {
        header('Location: listpost.php');
        exit;
    }
    
    $article = R::load('articles', $_GET['id']);
    if ($article->id == 0) {
        header('Location: listpost.php');
        exit;
    }

    $message = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $article->title_article = $_POST['title_article'];
        $article->content_article = $_POST['content_article'];

        if (empty($article->title_article) || empty($article->content_article)) {
            $message = '<p class="error">Veuillez remplire tout les champs.</p>';
        } else {
            R::store($article);
            $message = '<p class="success">Article modifié avec succès !</p>';
        }
    }
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Modifier l'Article</title>
</head>
<body>
    <div class="container">
    <h1>Modifier un article</h1>
        <?= $message ?>
        <form method="post" action="#">
            <label for="title_article">Titre :</label>
            <input type="text" name="title_article" id="title_article" value="<?= htmlspecialchars($article->title_article) ?>" required>
            <label for="content_article">Contenu :</label>
            <textarea name="content_article" id="content_article" required><?= htmlspecialchars($article->content_article) ?></textarea>
            <button type="submit">Modifier</button>
        </form>
        <a href="listpost.php">Retour au article</a>
    </div>
    </div>
</body>
</html>