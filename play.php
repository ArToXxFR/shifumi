<?php session_start();

require "connect_bdd.php";
$jeu_lance = false;

if(isset($_SESSION['pseudo']) && isset($_SESSION['image'])){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $jeu_lance = true;
        switch ($_POST['shifumi']) {
            case 'pierre':
                $icon = '/icons_jeu/pierre.png';
                break;
            case 'papier':
                $icon = '/icons_jeu/papier.png';
                break;
            case 'ciseaux':
                $icon = '/icons_jeu/ciseaux.png';
                break;
            default:
                echo "<script>alert('Erreur lors du choix du jeu');</script>";
                unset($_POST['shifumi']);
                header('Location: play.php');
        }
    }
} else {
    header('Location: index.php');
}

function userConnected(){
    if(isset($_SESSION['pseudo']) && isset($_SESSION['image'])){
        return true;
    } else{
        return false;
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
    <link href="css/style.css" rel="stylesheet">
    <script src="js/script.js"></script>
</head>
<body>
    <?php require('header.php'); ?>
    <?php if(!$jeu_lance){ ?>
    <span> Choisis l'un des 3 signes :</span>

    <form method="POST" action="play.php" onsubmit="return valider_jeu()">
        <div>
            <div>
                <p>Pierre</p>
                <img src="icons_jeu/pierre.png" alt="pierre">
                <input type="radio" name="shifumi" value="pierre" id="pierre" class="input-hidden" required>
                <label for="pierre" class="radio"><div class="inside-radio"></div></label>
            </div>
            <div>
                <p>Papier</p>
                <img src="icons_jeu/papier.png" alt="papier">
                <input type="radio" name="shifumi" value="papier" id="papier" class="input-hidden" required>
                <label for="papier" class="radio"><div class="inside-radio"></div></label>
            </div>
            <div>
                <p>Ciseaux</p>
                <img src="icons_jeu/ciseaux.png" alt="ciseaux">
                <input type="radio" name="shifumi" value="ciseaux" id="ciseaux" class="input-hidden" required>
                <label for="ciseaux" class="radio"><div class="inside-radio"></div></label>
            </div>
        </div>
        <input type="submit" value="Valider mon choix" class="open-button jaune">
    </form>
    <button onclick="document.location.href='index.php'" class="open-button rouge-pastel">Annuler la partie</button>

    <?php } else { ?>
        <span> C'est parti... </span>
        <span> SHI... FU... MI... </span>
        <img src="<?= $_SESSION['image']?>" alt="profil joueur" class="icons">
        <img src="<?= $icon ?>" alt="icon jeu">
    <?php } ?>
    <?php require('footer.php'); ?>

</body>
</html>