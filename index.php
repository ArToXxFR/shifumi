<?php session_start();

require "connect_bdd.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['pseudo']) && !isset($_SESSION['image'])) {
        // Connexion au compte avec le login
        if (isset($_POST['button-login'])) {
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
                    } else {
                        $_SESSION['pseudo'] = $userInfoConnected['pseudo'];
                        $_SESSION['image'] = $userInfoConnected['image'];
                    }
                } else {
                    echo "<script>openForm('login');</script>";
                    $incorrectId = true;
                }
            } else {
                echo "<script>openForm('login');</script>";
                $incorrectId = true;
            }
            // Création d'un nouveau compte
        } else if (isset($_POST['button-register'])) {
            $sth = $dbh->prepare("SELECT email FROM utilisateurs WHERE email=:email");
            $isNotError = $sth->execute(['email' => strtolower($_POST['email'])]);
            if (!$isNotError) {
                echo "Impossible de récupérer l'email";
            };
            $emailAlreadyExist = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = $dbh->prepare("SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo");
            $isNotError = $sth->execute(['pseudo' => $_POST['pseudo']]);
            if (!$isNotError) {
                echo "<script>alert('Impossible de récupérer le pseudo')</script>";
            };
            $pseudoAlreadyExist = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = $dbh->prepare('SELECT id FROM avatar WHERE image=:image');
            $isNotError = $sth->execute(['image' => $_POST['avatar']]);
            if (!$isNotError) {
                echo "<script>alert('Impossible de récupérer l'avatar')</script>";
            };
            $id_avatar = $sth->fetch(PDO::FETCH_ASSOC);
            // On cherche si le pseudo ou l'email est déjà présent dans la base de donnée
            if (!$emailAlreadyExist) {
                if (!$pseudoAlreadyExist) {
                    if ($_POST['password'] === $_POST['confirmPassword']) {
                        // Quand on arrive ici, il n'y a pas d'email déjà enregistrée(majuscules comprises) ni de pseudo et les deux mots de passes enregistrés sont les mêmes
                        $grain = "erwann";
                        $sel = "stpun20/20";
                        $password = password_hash($grain . $_POST['password'] . $sel, PASSWORD_ARGON2ID);
                        // Ici le mot de passe a été crypté avec la methode ARGON2ID avec un grain de sel ce qui rend la sécurité maximale
                        $infosCompte = [
                            'pseudo' => $_POST['pseudo'],
                            'email' => strtolower($_POST['email']),
                            'password' => $password,
                            'id_avatar' => $id_avatar['id'],
                        ];
                        $sth = $dbh->prepare("INSERT INTO utilisateurs(pseudo, email, password) VALUES (:pseudo, :email, :password);
                        INSERT INTO utilisateurs_has_avatar(id_utilisateurs, id_avatar) VALUES (LAST_INSERT_ID(), :id_avatar);
                        INSERT INTO stats(id_user) VALUES (LAST_INSERT_ID());");
                        $isNotError = $sth->execute($infosCompte);
                        // Ici on créer un utilisateur dans la table "utilisateurs" et on associe sa clef étrangère dans la table stats
                        if ($isNotError) {
                            echo "Le compte a bien été créer";
                        } else {
                            echo "Erreur lors de la création du compte";
                        };
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

$sth = $dbh->prepare('SELECT id, nom, image FROM avatar;');
$isNotError = $sth->execute();
$avatar_profile = $sth->fetchAll(PDO::FETCH_ASSOC);

function userConnected()
{
    if (isset($_SESSION['pseudo']) && isset($_SESSION['image'])) {
        return true;
    } else {
        return false;
    }
}


$sth = $dbh->prepare("SELECT image FROM avatar WHERE nom='music-bender';");
$sth->execute();
$image = $sth->fetch(PDO::FETCH_ASSOC);

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
    <?php require('header.php'); ?>
    <div class="page_container">
        <div class="description">
            Défier <span class="rayures">Hal</span> Bender à SHIFUMI
        </div>
        <?php if (userConnected()) { ?>
            <button class="open-button jaune" onclick="document.location.href='play.php'"><img class="icon-button" src="/img/joystick.svg" alt="joystick">Tenter votre chance<img class="icon-button" src="img/fleche.svg" alt="flèche"> </button>
        <?php } else { ?>
            <button class="open-button jaune" onclick="openForm('login')"><img class="icon-button" src="/img/joystick.svg" alt="joystick">Tenter votre chance<img class="icon-button" src="img/fleche.svg" alt="flèche"> </button>
        <?php } ?>
        <button class="open-button rouge-pastel" onclick="openForm('popupForm')"><img class="icon-button" src="/img/aide.svg" alt="aide">Rappel des règles<img class="icon-button" src="img/fleche.svg" alt="flèche"> </button>
    </div>
    <?php require('footer.php'); ?>

    <!-- Fond noir transparent lors des popup -->
    <div id="background"></div>
    <!-- Popup des règles -->
    <div class="position-popup" id="popupForm">
        <div class="form-popup">
            <h2 class="title-popup rouge-pastel"><img class="icon-regles" src="/img/aide.svg" alt="aide">Rappel des Règles</h2>
            <p>À chaque partie, le joueur choisit l'une ces trois actions</p>
            <ul>
                <li>pierre</li>
                <li>papier</li>
                <li>ciseaux</li>
            </ul>
            <ol>
                <li><img class="taille-image" src="/img/Bouton - Pierre.svg" alt="icon pierre"></li>
                <li><img class="taille-image" src="/img/Bouton - Papier.svg" alt="icon papier"></li>
                <li><img class="taille-image" src="/img/Bouton - Ciseaux.svg" alt="icon ciseaux"></li>
            </ol>
            <p>La <strong class="mots-gras">pierre</strong> bat les <strong class="mots-gras">ciseaux</strong> en les émoussant.</p>
            <p>Le <strong class="mots-gras">papier</strong> bat la <strong class="mots-gras">pierre</strong> en l'enveloppant.</p>
            <p>Les <strong class="mots-gras">ciseaux</strong> battent le <strong class="mots-gras">papier</strong> en la coupant.</p>
            <p>
                Il peut y avoir des matchs nulles si le joueur et Bender choisissent
                la même action.
            </p>
        </div>
        <button class="close-popup rouge-pastel" onclick="closeForm('popupForm')">✖</button>
    </div>
    <!-- Popup du login -->
    <div class="position-popup" id="login">
        <div class="form-popup">
            <span class="title-popup border-radius-top jaune">Vous n'avez pas de compte ?</span>
            <button class="button-popup jaune" onclick="closeForm('login'); openForm('register');">Créer un nouveau compte</button>
            <span class="title-popup border-top cyan ombre-top">Vous avez déjà un compte ?</span>
            <form action="index.php" method="POST" class="flex-login">
                <input name="username" type="text" maxlength="25" placeholder="Nom d'utilisateur / Adresse email" class="input-login">
                <input name="password" type="password" placeholder="Mot de passe" class="input-login">
                <span class="mots-gras">Mot de passe oublié ?</span>
                <input name="button-login" type="submit" value="Se connecter" class="button-popup cyan">
            </form>
        </div>
        <button class="close-popup rouge-pastel" onclick="closeForm('login')">✖</button>
    </div>
    <!-- Popup de register -->
    <div class="position-popup" id="register">
        <div class="form-popup">
            <span class="title-popup border-radius-top jaune">Création de compte</span>
            <form action="index.php" method="POST" class="flex-login">
                <div class="first-step-register" id="first-step">
                    <span>1/2 - Vos identifiants</span>
                    <input name="email" type="email" placeholder="Taper votre email..." required>
                    <input type="password" name="password" placeholder="Taper votre mot de passe..." required>
                    <input type="password" name="confirmPassword" placeholder="Confirmer le mot de passe" required>
                </div>
                <div class="second-step-register" id="second-step">
                    <span>2/2 - Personnalisation</span>
                    <input name="pseudo" type="text" placeholder="Taper votre pseudo..." required>
                    <select name="avatar" id="f_selectTrie" onchange="changeAvatar()" required>
                        <?php foreach ($avatar_profile as $avatar) { ?>
                            <option value="<?= $avatar['image'] ?>"><?= $avatar['nom'] ?></option>
                        <?php } ?>
                    </select>
                    <img src="/avatar/avatars_fry.png" alt="avatar" id="avatar" width="50px">
                    <input type="submit" name="button-register" value="Terminer">
                </div>
            </form>
            <div class="first-step-register" id="first-step-buttons">
                <button onclick="closeForm('register'); openForm('login');">Précédent</button>
                <button onclick="nextstep();">Suivant</button>
            </div>
            <div class="second-step-register" id="second-step-buttons">
                <button onclick="previousstep()">Précédent</button>

            </div>
        </div>
        <button class="close-popup rouge-pastel" onclick="closeForm('login'); closeForm('register');">✖</button>
    </div>
    <!-- Popup de deconnection -->
    <div class="position-popup" id="deconnection">
        <div class="form-popup">
            <h2 class="title-popup rouge-pastel">Se déconnecter</h2>
            <span class="choice">Etes-vous sur de vouloir vous déconnecter ?</span>
            <button onclick="document.location.href='deconnection.php'" class="button-popup rouge-pastel"> <img class="icon-button" src="img/icon_exit.svg" alt="icon exit">Oui je veux me déconnecter<img class="icon-button" src="img/fleche.svg" alt="flèche"></button>
            <button onclick="document.location.href='index.php'" class="button-popup jaune">C'était une erreur, annuler</button>
            <img src="bender_message/bender_terminator.svg" alt="Au revoir de bender">
        </div>
        <button class="close-popup rouge-pastel" onclick="closeForm('deconnection')">✖</button>
    </div>
</body>

</html>