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
        $sth = $dbh->prepare('UPDATE stats 
                            INNER JOIN utilisateurs ON utilisateurs.id = stats.id_user
                            SET win = win + 1
                            WHERE pseudo=:pseudo;');
        $sth->execute(['pseudo' => $_SESSION['pseudo']]);
        break;
    case 'perdu':
        $compte_rendu_resultat = [$choix_bender, 'defaite', $choix_utilisateur];
        $sth = $dbh->prepare('UPDATE stats 
                            INNER JOIN utilisateurs ON utilisateurs.id = stats.id_user
                            SET loose = loose + 1
                            WHERE pseudo = :pseudo;');
        $isNotError = $sth->execute(['pseudo' => $_SESSION['pseudo']]);
        if(!$isNotError){ print_r($sth->errorInfo()); }
        break;
    case 'egalite':
        $compte_rendu_resultat = [$choix_bender, 'null', $choix_utilisateur];
        $sth = $dbh->prepare('UPDATE stats
                            INNER JOIN utilisateurs ON utilisateurs.id = stats.id_user 
                            SET nulle = nulle + 1
                            WHERE pseudo = :pseudo;');
        $sth->execute(['pseudo' => $_SESSION['pseudo']]);
        break;
    default:
        echo "<script>alert('Erreur lors du resultat');</script>";
        header('Location: play.php');
}


$_SESSION['resultat'] = $compte_rendu_resultat;
header('Location: play.php');
