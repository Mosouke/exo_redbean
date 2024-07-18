<?php
    require_once 'connect.php';
    $message = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mail_user = $_POST['mail_user'];
        $pass_user = $_POST['pass_user'];

        if (empty($_POST['mail_user']) || empty($_POST['pass_user'])) {
            $message = '<p class="error">Veuillez remplir tous les champs.</p>';
        } else if (!filter_var($mail_user, FILTER_VALIDATE_EMAIL)) {
        $message = '<p class="error">Veuillez entrer une adresse e-mail valide.</p>';
        } else {
            $user = R::findOne('users', 'mail_user = ?', [$mail_user]);
            if ($user && password_verify($pass_user, $user->pass_user)) {
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['name_user'] = $user->name_user;
                $message = '<p class="success">Connexion réussie !</p>';
                header('Location: crud/listpost.php');
                exit;
            } else {
            $message = '<p class="error">Adresse e-mail ou mot de passe incorrect.</p>';
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
    <title>Connexion</title>
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <?= $message ?>
        <form method="post" action="#">
            <label for="mail_user">Mail :</label>
            <input type="email" name="mail_user" id="mail_user" required>
            <label for="pass_user">Mot de passe :</label>
            <input type="password" name="pass_user" id="pass_user" required>
            <button type="submit">Se connecter</button>
        </form>
        <a href="register.php">Inscription</a>
    </div>
</body>
</html>