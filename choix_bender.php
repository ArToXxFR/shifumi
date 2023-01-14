<?php 

/*-------------------------------------------------------------------
    Cette page va uniquement servir pour 
    créer l'algorithme pour le choix de Bender
    Cela va éviter de recommencer le jeu lors 
    de l'actualisation de la page
---------------------------------------------------------------------*/

session_start();

require_once __DIR__ . "/includes/connect_bdd.php";
require_once __DIR__ . "/includes/functions_request_bdd.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: play.php');
}

/* Ajout de l'adresse IP du joueur ainsi que la date et l'heure */

$sth = $dbh->prepare('UPDATE user 
SET ip=:ip, date_last_game= (CURRENT_TIMESTAMP)
WHERE pseudo = :pseudo;');
$sth->execute(['pseudo' => $_SESSION['pseudo'], 'ip' => $_SERVER['REMOTE_ADDR']]);

/* Comparaison pour savoir si le joueur a gagné ou non */

$choix_utilisateur = $_POST['shifumi'];
$choix_bender = algo_choix_bender();
$shifumi = [
    'pierre' => [
        'pierre' => 'egalite',
        'papier' => 'perdu',
        'ciseaux' => 'gagne',
    ],
    'papier' => [
        'pierre' => 'gagne',
        'papier' => 'egalite',
        'ciseaux' => 'perdu',
    ],
    'ciseaux' => [
        'pierre' => 'perdu',
        'papier' => 'gagne',
        'ciseaux' => 'egalite',
    ]
];

/* On ajoute ici le score que l'utilisateur a obtenu */

$resultat = $shifumi[$choix_utilisateur][$choix_bender];
switch($resultat){
    case 'gagne':
        $compte_rendu_resultat = [$choix_bender, 'victoire', $choix_utilisateur];
        $sth = $dbh->prepare('UPDATE user 
                            SET wins = wins + 1
                            WHERE pseudo=:pseudo;');
        $sth->execute(['pseudo' => $_SESSION['pseudo']]);
        break;
    case 'perdu':
        $compte_rendu_resultat = [$choix_bender, 'defaite', $choix_utilisateur];
        $sth = $dbh->prepare('UPDATE user 
                            SET looses = looses + 1
                            WHERE pseudo = :pseudo;');
        $isNotError = $sth->execute(['pseudo' => $_SESSION['pseudo']]);
        break;
    case 'egalite':
        $compte_rendu_resultat = [$choix_bender, 'null', $choix_utilisateur];
        $sth = $dbh->prepare('UPDATE user 
                            SET nuls = nuls + 1
                            WHERE pseudo = :pseudo;');
        $sth->execute(['pseudo' => $_SESSION['pseudo']]);
        break;
    default:
        echo "<script>alert('Erreur lors du resultat');</script>";
        header('Location: play.php');
}

/* Logique du choix que bender va faire */

function algo_choix_bender() {
    $_SESSION['tour']+= 1;
    $options = ['pierre', 'papier', 'ciseaux'];
    $_SESSION['choix_utilisateur'][$_SESSION['tour']] = $_POST['shifumi'];
    if($_SESSION['tour'] == 1){
        $_SESSION['choix_bender'][$_SESSION['tour']] = $options[array_rand($options)];
        $_SESSION['compteur_choix'][$_SESSION['choix_bender'][$_SESSION['tour']]]++;
    } elseif($_SESSION['tour'] == 2){
        $_SESSION['choix_bender'][$_SESSION['tour']] = inverse_joueur($_SESSION['choix_utilisateur'][1]);
        $_SESSION['compteur_choix'][$_SESSION['choix_bender'][$_SESSION['tour']]]++;
    } elseif($_SESSION['tour'] == 3){
        $_SESSION['choix_bender'][$_SESSION['tour']] = $_SESSION['choix_bender'][1];
        $_SESSION['compteur_choix'][$_SESSION['choix_bender'][$_SESSION['tour']]]++;
    } elseif($_SESSION['tour'] == 4){
        $_SESSION['choix_bender'][$_SESSION['tour']] = array_search(min($_SESSION['compteur_choix']), $_SESSION['compteur_choix']);
        $_SESSION['compteur_choix'][$_SESSION['choix_bender'][$_SESSION['tour']]]++;
    } elseif($_SESSION['tour'] == 5){
        $_SESSION['choix_bender'][$_SESSION['tour']] = $_SESSION['choix_bender'][4];
    }
    return $_SESSION['choix_bender'][$_SESSION['tour']];
}

/* Algorithme pour choisir le contre de ce que le joueur a choisit au tour d'avant */

function inverse_joueur($choix_utilisateur) {
    switch($choix_utilisateur){
        case 'pierre':
            return 'papier';
            break;
        case 'papier':
            return 'ciseaux';
            break;
        case 'ciseaux':
            return 'pierre';
            break;
        default:
            echo "<script>alert('Erreur lors du choix utilisateur');</script>";
            header('Location: play.php');
    }
}

$_SESSION['resultat'] = $compte_rendu_resultat;
header('Location: play.php');

