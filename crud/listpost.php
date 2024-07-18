<?php
require_once '../connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$articles = R::findAll('articles', 'ORDER BY created DESC');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Tableau de bord</title>
</head>
<body>
    <div class="container">
        <h1>Tableau de bord</h1>
        <a href="create_article.php">Créer un article</a>
        <h2>Liste des articles</h2>

        <?php if (count($articles) > 0): ?>
            <?php foreach ($articles as $article): ?>
                <div class="article">
                    <h3><?= htmlspecialchars($article->title_article) ?></h3>
                    <p><?= nl2br(htmlspecialchars($article->content_article)) ?></p>
                    <p><small>Créé le <?= htmlspecialchars($article->created) ?></small></p>
                    <a href="edit_article.php?id=<?= $article->id ?>">Modifier</a>
                    <a href="delete_article.php?id=<?= $article->id ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');">Supprimer</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article trouvé</p>
        <?php endif; ?>
    </div>
</body>
</html>
