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
require_once __DIR__ . "/includes/functions_shifumi.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: play.php');
}

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
        if(!$isNotError){ print_r($sth->errorInfo()); }
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

/* Ajout de l'adresse IP du joueur */

$sth = $dbh->prepare('UPDATE user 
SET ip=:ip, date_last_game= (CURRENT_TIMESTAMP)
WHERE pseudo = :pseudo;');
$sth->execute(['pseudo' => $_SESSION['pseudo'], 'ip' => $_SERVER['REMOTE_ADDR']]);

$_SESSION['resultat'] = $compte_rendu_resultat;
header('Location: play.php');

