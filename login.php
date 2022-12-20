<?php session_start(); 

require "connect_bdd.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!isset($_SESSION['pseudo']) && !isset($_SESSION['image'])) {
        $grain = "erwann";
        $sel = "stpun20/20";
        $login = [
            'username' => $_POST['username'],
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
                $sth = $dbh->prepare("SELECT pseudo, avatar.image 
            FROM utilisateurs
            INNER JOIN utilisateurs_has_avatar ON utilisateurs.id = utilisateurs_has_avatar.id_utilisateurs
            INNER JOIN avatar ON avatar.id = utilisateurs_has_avatar.id_avatar
            WHERE utilisateurs.email=:email");
                $isNotError = $sth->execute(['email' => $userInfoLogin['email']]);
                $userInfoConnected = $sth->fetch(PDO::FETCH_ASSOC);
                if (!$isNotError) {
                    echo "Impossible de récupérer les infos de l'utilisateur connecté";
                }
                $_SESSION['pseudo'] = $userInfoConnected['pseudo'];
                $_SESSION['image'] = $userInfoConnected['image'];

            } else {
                echo "<script>openForm('login');</script>";
            }
        } else {
            echo "<script>openForm('login');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=*, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/script.js"></script>
    <title>Document</title>
</head>
<body>
<div class="position-popup" id="login">
        <div class="form-popup">
            <h2 class="title-popup rouge-pastel">Se connecter</h2>
            <form action="index.php" method="POST">
                <input name="username" type="text" maxlength="25" placeholder="Nom d'utilisateur / Adresse email" class="input-login">
                <input name="password" type="password" placeholder="Mot de passe" class="input-login">
                <input name="button-login" type="submit" value="Envoyer" class="input-login">
                <span>Pas de compte ? <a href="#">En créer un</a>
            </form>
        </div>
        <button class="close-popup rouge-pastel" onclick="closeForm('login')">✖</button>
    </div>

</body>
</html>