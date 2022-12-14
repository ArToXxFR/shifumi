<?php

require "connect_bdd.php";
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $grain = "erwann";
    $sel = "stpun20/20";
    $login = ['username' => $_POST['username'],
                'email' => $_POST['username'],
    ];
    $sth = $dbh->prepare("SELECT pseudo, password, email FROM utilisateurs WHERE pseudo=:username OR email=:username");
    $isNotError = $sth->execute($login);
    $userInfoLogin = $sth->fetch(PDO::FETCH_ASSOC);
    // L'utilisateur a saisi une email et on récupère le pseudo et le mot de passe même si il est incorrect
    if (isset($_POST['button-login']) && $userInfoLogin) {
        $passwordPOST = $_POST['password'];
        $passwordBDD = $userInfoLogin['password'];
        if (password_verify($grain . $passwordPOST . $sel, $passwordBDD)) {
            // On vérifie ici si les deux mots de passe correspondent
            echo "Vous êtes connectés";
            $sth = $dbh->prepare("SELECT pseudo, avatar.image 
            FROM utilisateurs
            INNER JOIN utilisateurs_has_avatar ON utilisateurs.id = utilisateurs_has_avatar.id_utilisateurs
            INNER JOIN avatar ON avatar.id = utilisateurs_has_avatar.id_avatar
            WHERE utilisateurs.email=:email");
            $isNotError = $sth->execute(['email' => $userInfoLogin['email']]);
            $userInfoConnected = $sth->fetch(PDO::FETCH_ASSOC);
            if(!$isNotError){echo "Impossible de récupérer les infos de l'utilisateur connecté";};
            var_dump($userInfoConnected);
            $_SESSION['pseudo'] = $userInfoConnected['pseudo'];
            $_SESSION['image'] = $userInfoConnected['image'];
            
        } else {
            echo "Identifiants Incorrects";
        }
    } else {
        echo "Identifiants Incorrects";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="login.php">
        <input name="username" placeholder="Nom d'utilisateur / Adresse email" type="text">
        <input name="password" placeholder="Mot de passe" type="password">
        <input name="button-login" type="submit" value="Se connecter">
    </form>
    <p>Vous n'avez pas de compte ?
    <a href="register.php">En créer un !</a>
    <a href="index.php">Home</a>
</body>
</html>