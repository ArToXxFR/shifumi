<?php session_start();

require_once __DIR__ . "/connect_bdd.php";
require_once __DIR__ . "/includes/functions_request_bdd.php";
$jeu_lance = false;

if (userConnected()) {
    if (isset($_SESSION['resultat'])) {
        $jeu_lance = true;
        /* Affichage de l'icone que le joueur a choisi
        Ainsi que l'icone que bender a choisi */
        $choix_utilisateur = $_SESSION['resultat'][2];
        $choix_bender = $_SESSION['resultat'][0];
        $resultat_jeu = $_SESSION['resultat'][1];
        $icon_choix_utilisateur = icon_jeu($choix_utilisateur);
        $icon_choix_bender = icon_jeu($choix_bender);
        /* Une fois arrivé au tour 5, on réinitialise tout
        pour que l'algorithme reparte de zéro */
        if ($_SESSION['tour'] == 5) {
            $_SESSION['tour'] = 0;
            $_SESSION['choix_bender'] = [];
            $_SESSION['compteur_choix'] = ['pierre' => 0, 'papier' => 0, 'ciseaux' => 0];
        }
        unset($_SESSION['resultat']);
    }
} else {
    header('Location: index.php');
}

if(!isset($_SESSION['already_played'])){
    $_SESSION['already_played'] = 1;
    date_first_game($dbh);
}

/* Affichage de l'icon selectionné par le joueur ou par bender */

function icon_jeu($choix)
{
    switch ($choix) {
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
    return $icon;
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu shifumi</title>
    <link href="css/style.css" rel="stylesheet">
    <script src="js/script.js"></script>
</head>

<body>
    <?php require_once __DIR__ . "/includes/header.php"; ?>
    <?php if (!$jeu_lance) { ?>
        <div class="page_container">
            <div class="description mots_gras"> Choisis l'un des 3 signes :</div>
            <form method="POST" action="choix_bender.php" onsubmit="return valider_jeu()">
                <div class="container">
                    <div class="box">
                        <p class="mots_gras">Pierre</p>
                        <img src="/icons_jeu/pierre.png" alt="pierre">
                        <input type="radio" name="shifumi" value="pierre" id="pierre" class="input-hidden" required>
                        <label for="pierre" class="radio">
                            <div class="inside-radio"></div>
                        </label>
                    </div>
                    <div class="box">
                        <p class="mots_gras">Papier</p>
                        <img src="/icons_jeu/papier.png" alt="papier">
                        <input type="radio" name="shifumi" value="papier" id="papier" class="input-hidden" required>
                        <label for="papier" class="radio">
                            <div class="inside-radio"></div>
                        </label>
                    </div>
                    <div class="box">
                        <p class="mots_gras">Ciseaux</p>
                        <img src="/icons_jeu/ciseaux.png" alt="ciseaux">
                        <input type="radio" name="shifumi" value="ciseaux" id="ciseaux" class="input-hidden" required>
                        <label for="ciseaux" class="radio">
                            <div class="inside-radio"></div>
                        </label>
                    </div>
                </div>
                <button type="submit" class="jaune bouton">Valider mon choix</button>
            </form>
            <button onclick="document.location.href='index.php'" class="button rouge-pastel bouton">Annuler la partie</button>
        </div>
    <?php } else { ?>
        <div class="page_container fade_out">
            <div class="container">
                <div class="futura_28px_medium lancement">C'est parti...</div>
                <div class="futura_50px_medium mots_gras">SHI... FU... MI !</div>
                <div class="container">
                    <div class="box1">
                        <img src="<?= htmlspecialchars($_SESSION['image']) ?>" alt="profil joueur" class="img_profile size_img_profile">
                        <img src="<?= $icon_choix_utilisateur ?>" alt="icon jeu">
                    </div>
                    <div class="box1">
                        <img src="<?= $icon_choix_bender; ?>" alt="icon jeu">
                        <img src="/medias/avatars/avatars_bender.png" alt="profil joueur" class="img_profile size_img_profile">
                    </div>
                </div>
            </div>
        </div>

        <div class="page_container fade_in">
            <?php switch ($resultat_jeu) {
                case 'victoire': ?>
                    <span class="after_game_message futura_28px_medium"> Bravo tu as gagné ! </span>
                <?php break;
                case 'defaite': ?>
                    <span class="after_game_message futura_28px_medium"> Tu as perdu ! </span>
                <?php break;
                case 'null': ?>
                    <span class="after_game_message futura_28px_medium"> Match nul ! </span>

            <?php break;
            } ?>
            <div class="container">
                <div class="box1">
                    <img src="<?= htmlspecialchars($_SESSION['image']) ?>" alt="profil joueur" class="img_profile size_img_profile">
                    <img src="<?= $icon_choix_utilisateur ?>" alt="icon jeu">

                </div>
                <div class="box1">
                    <img src="<?= $icon_choix_bender; ?>" alt="icon jeu">
                    <img src="/medias/avatars/avatars_bender.png" alt="profil joueur" class="img_profile size_img_profile">
                </div>
            </div>
            <?php switch ($resultat_jeu) {
                case 'victoire': ?>
                    <div class="image_center"><img src="/medias/bender_message/bender_you_win_1.png" alt="Bender rageux"></div>
                <?php break;
                case 'defaite': ?>
                    <div class="image_center"><img src="/medias/bender_message/bender_you_lose_1.png" alt="Bender se moque"></div>
                <?php break;
                case 'null': ?>
                    <div class="image_center"><img src="/medias/bender_message/bender_match_nul_1.png" alt="Bender provoque"></div>

            <?php break;
            } ?>
            <button onclick="document.location.href='index.php'" class="rouge-pastel bouton_gauche">Accueil</button>
            <button onclick="document.location.href='play.php'" class="jaune bouton_droite">Rejouer</button>
        </div>


    <?php } ?>
    <?php require_once __DIR__ . "/includes/footer.php";
    require_once __DIR__ . "/includes/popups.php"; ?>
</body>

</html>