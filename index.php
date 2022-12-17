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
                echo "Vous êtes connectés";
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
                echo "Identifiants Incorrects";
            }
        } else {
            echo "Identifiants Incorrects";
        }
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
    <button class="open-button jaune" onclick="">Tenter votre chance</button>
    <button class="open-button rouge-pastel" onclick="openForm('popupForm')">Rappel des règles</button>
    
    <div class="footer">
        <button class="connection-button score purple" onclick="">Tableau des scores</button>
        <?php if(isset($_SESSION['pseudo']) && isset($_SESSION['image'])){ ?>
                <button onclick="" class="profile cyan"><img src="<?= $_SESSION['image'] ?>" alt='avatar' class="img-profile"><span><?= $_SESSION['pseudo']?></span></button>
                <button onclick="" class="deconnection-button rouge-pastel"><a href='deconnection.php'>Se déconnecter</a></button>
        <?php } else { ?>
                <button class="connection-button cyan" onclick="openForm('login')">Se connecter</button>
        <?php } ?>
    </div>

    <!-- Fond noir transparent lors des popup -->
    <div id="background"></div>
    <!-- Popup des règles -->
    <div class="position-popup" id="popupForm">
        <div class="form-popup">
            <h2 class="title-popup rouge-pastel">Rappel des règles</h2>
            <p>À chaque partie, le joueur choisit l'une des trois actions suivantes :</p>
            <ul>
                <li>La pierre</li>
                <li>Le papier</li>
                <li>Les ciseaux</li>
            </ul>
            <p>La pierre bat les ciseaux en les émoussant.</p>
            <p>Le papier bat la pierre en l'enveloppant.</p>
            <p>Les ciseaux battent le papier en la coupant.</p>
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

        <script>
      function openForm(id) {
        document.getElementById(id).style.display = "block";
        document.getElementById("background").style.display = "block";
      }

      function closeForm(id) {
        document.getElementById(id).style.display = "none";
        document.getElementById("background").style.display = "none";
      }
    </script>
</body>
</html>

<?php