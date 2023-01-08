<?php

/* Vérification si les joueur est connecté */

function userConnected(){
    if (isset($_SESSION['pseudo']) && isset($_SESSION['image'])) {
        return true;
    } else {
        return false;
    }
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