<?php session_start();

require "connect_bdd.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                $incorrectId = true;
            }
        } else {
            echo "<script>openForm('login');</script>";
            $incorrectId = true;
        }
    }
}

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
    <div class="flex">
        <div class="background-title">
            <h1 class="title textmulticolor">SHIFUMI</h1>
        </div>
    </div>
    <div class="description">
        Défier <span class="rayures">Hal</span> Bender à SHIFUMI
    </div>
    <?php if (userConnected()) { ?>
        <button class="open-button jaune" onclick="document.location.href='play.php'">Tenter votre chance</button>
    <?php } else { ?>
        <button class="open-button jaune" onclick="openForm('login')"><img src="/img/joystick.svg" alt="joystick">Tenter votre chance</button>
    <?php } ?>
    <button class="open-button rouge-pastel" onclick="openForm('popupForm')"><img src="/img/aide.svg" alt="aide"> Rappel des règles</button>

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
                <span>Mot de passe oublié ?</span>
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
                    <input type="email" placeholder="Taper votre email...">
                    <input type="password" placeholder="Taper votre mot de passe...">
                    
                </div>
                <div class="second-step-register" id="second-step">
                    <input type="text" placeholder="Taper votre pseudo...">
                </div>
            </form>
            <div class="first-step-register" id="first-step">
                <button onclick="closeForm('register'); openForm('login');">Précédent</button>
                <button onclick="nextstep();">Suivant</button>
            </div>
            <div class="second-step-register" id="second-step">
                <button onclick="previousstep()">Précédent</button>
                <button onclick="">Terminer</button>
            </div>
        </div>
        <button class="close-popup rouge-pastel" onclick="closeForm('login')">✖</button>
    </div>

</body>

</html>