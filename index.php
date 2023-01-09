<?php session_start();

require_once __DIR__ . "/includes/connect_bdd.php";
require_once __DIR__ . "/includes/constants.php";
require_once __DIR__ . "/includes/functions_request_bdd.php";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    /* On vérifie si l'utilisateur n'est pas déjà connecté */ 

    if (!userConnected()) {

        /* On vérifie que le formulaire soit un login et non pas un register */

        if ($_POST['name'] == 'login') {
            $login = [
                'username' => $_POST['username'],
                'email' => $_POST['username'],
            ];

            /* L'utilisateur a saisi une email et on récupère le pseudo et le mot de passe même si il est incorrect */

            $sth = $dbh->prepare("SELECT pseudo, password, email FROM utilisateurs WHERE pseudo=:username OR email=:username");
            $isNotError = $sth->execute($login);
            $userInfoLogin = $sth->fetch(PDO::FETCH_ASSOC);

            /* On vérifie ici si il a trouvé un utilisateur dans la BDD avec le pseudo que l'utilisateur a saisi */

            if ($userInfoLogin) {

                /* On vérifie que le mot de passe corresponde bien alors celui de l'utilisateur */

                if(password_verify(GRAIN . $_POST['password'] . SEL, $userInfoLogin['password'])) {
                    /* Cette fonction va récupérer toutes les informations de l'utilisateur qui vient de se connecter
                       pseudo, avatar, nombre de wins, looses, nulls
                       Tout est stocké dans la variable superglobal _SESSION */

                    users_infos($dbh, $userInfoLogin);
                } else {
                    echo "<script>openForm('login');</script>";
                    $incorrectId = true;
                }
            } else {
                //Le pseudo ou l'adresse email n'a pas été trouvé dans la base de données
                echo "<script>openForm('login');</script>";
                $incorrectId = true;
            }

        /* On vérifie que le formulaire soit un register et non pas un login */

        } else if ($_POST['name'] == 'register') {

            /* On vérifie ici si l'email saisie par l'utilisateur existe déjà dans la BDD */

            $sth = $dbh->prepare("SELECT email FROM utilisateurs WHERE email=:email");
            $sth->execute(['email' => strtolower($_POST['email'])]);
            $emailAlreadyExist = $sth->fetch(PDO::FETCH_ASSOC);

            /* On vérifie ici si le pseudo saisie par l'utilisateur existe déjà dans la BDD */

            $sth = $dbh->prepare("SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo");
            $sth->execute(['pseudo' => $_POST['pseudo']]);
            $pseudoAlreadyExist = $sth->fetch(PDO::FETCH_ASSOC);

            $sth = $dbh->prepare('SELECT id FROM avatar WHERE image=:image');
            $isNotError = $sth->execute(['image' => $_POST['avatar']]);
            $id_avatar = $sth->fetch(PDO::FETCH_ASSOC);
            if (!$isNotError) {
                echo "<script>alert('Impossible de récupérer l'avatar')</script>";
            }
            
            /* On cherche si le pseudo ou l'email est déjà présent dans la base de donnée */
            if (empty($emailAlreadyExist)) {
                if (empty($pseudoAlreadyExist)) {
                    if ($_POST['password'] === $_POST['confirmPassword']) {

                        /* Quand on arrive ici, il n'y a pas d'email déjà enregistrée(majuscules comprises) ni de pseudo et les deux mots de passes enregistrés sont les mêmes 
                           Ensuite le mot de passe est crypté avec la methode ARGON2ID avec un grain de sel ce qui rend la sécurité maximale */

                        $password = password_hash(GRAIN . $_POST['password'] . SEL, PASSWORD_ARGON2ID);
                        
                        $infosCompte = [
                            'pseudo' => $_POST['pseudo'],
                            'email' => strtolower($_POST['email']),
                            'password' => $password,
                            'id_avatar' => $id_avatar['id'],
                        ];

                        /* Appel de la fonction qui va créer l'utilisateur dans la base de données */

                        creation_compte($dbh, $infosCompte);
                        
                    } else {
                        echo "<script>alert('Les deux mots de passe ne correspondent pas')</script>";
                    }
                } else {
                    echo "<script>alert('Pseudo déjà utilisée')</script>";
                }
            } else {
                echo "<script>alert('Adresse email déjà utilisée')</script>";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/script.js"></script>

    <title>Shifumi</title>
</head>

<body>
    <?php require_once __DIR__ . "/includes/header.php"; ?>
    <div class="page_container">
        <div class="description">
            Défier <span class="rayures">Hal</span> Bender à SHIFUMI
        </div>
        <?php if (userConnected()) { 
            if(!isset($_SESSION['already_played'])){
                $_SESSION['already_played'] = 1;
                date_first_game($dbh); ?>
                <button class="open-button jaune" onclick="document.location.href='play.php'">Faire votre 1ère partie</button>
            <?php } else { ?>
                <button class="open-button jaune" onclick="document.location.href='play.php'">Retenter votre chance</button>
        <?php }} else { ?>
            <button class="open-button jaune" onclick="openForm('login')">Tenter votre chance</button>
        <?php } ?>
        <button class="open-button rouge-pastel" onclick="openForm('popupForm')">Rappel des règles</button>
    </div>
    <?php require_once __DIR__ . "/includes/footer.php"; 
    require_once __DIR__ . "/includes/popups.php"?>
</body>

</html>