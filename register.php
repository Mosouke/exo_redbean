<?php
require_once 'connect.php';
$message = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = R::dispense('users');
    $users->name_user = $_POST['name_user'];
    $users->mail_user = $_POST['mail_user'];
    $users->pass_user = password_hash($_POST['pass_user'], PASSWORD_DEFAULT);
    $users->created = date('d-m-Y H:i:s'); 

    if (empty($users->name_user) || empty($users->mail_user) || empty($_POST['pass_user'])) {
        $message = '<p class="error">Veuillez remplir tous les champs.</p>';
    } else if (!filter_var($users->mail_user, FILTER_VALIDATE_EMAIL)) {
        $message = '<p class="error">Veuillez entrer une adresse e-mail valide.</p>';
    } else {
        $existingUser = R::findOne('users', 'mail_user = ?', [$users->mail_user]);
        if ($existingUser) {
            $message = '<p class="error">Cette adresse e-mail est déjà utilisée. Vous pouvez vous connecter <a href="login.php">ici</a>.</p>';
        } else {
            $id = R::store($users);
            $message = '<p class="success">Inscription réussie !</p>';
            header('Location login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <?= $message ?>
        <form method="post" action="#">
            <label for="name_user">Nom :</label>
            <input type="text" name="name_user" id="name_user" required>
            <label for="mail_user">Mail :</label>
            <input type="email" name="mail_user" id="mail_user" required>
            <label for="pass_user">Mot de passe :</label>
            <input type="password" name="pass_user" id="pass_user" required>
            <button type="submit">S'inscrire</button>
        </form>
        <a href="login.php">Connexion</a>
    </div>
</body>
</html>
