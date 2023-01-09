<?php

/* Vérification si les joueur est connecté */

function userConnected(){
    if (isset($_SESSION['pseudo']) && isset($_SESSION['image'])) {
        return true;
    } else {
        return false;
    }
}

/* Récupère toutes les informations sur l'utilisateur lorsqu'il se connecte */

function users_infos($dbh, $userInfoLogin){
    $sth = $dbh->prepare("SELECT pseudo, avatar.image, stats.win, stats.loose, stats.nulle
                    FROM utilisateurs
                    INNER JOIN utilisateurs_has_avatar ON utilisateurs.id = utilisateurs_has_avatar.id_utilisateurs
                    INNER JOIN avatar ON avatar.id = utilisateurs_has_avatar.id_avatar
                    INNER JOIN stats ON utilisateurs.id = stats.id_user
                    WHERE utilisateurs.email=:email;");
    $isNotError = $sth->execute(['email' => $userInfoLogin['email']]);
    $userInfoConnected = $sth->fetch(PDO::FETCH_ASSOC);
    if ($isNotError) {
        $_SESSION['pseudo'] = $userInfoConnected['pseudo'];
        $_SESSION['image'] = $userInfoConnected['image'];
        $_SESSION['stats_user'] = ['win' => $userInfoConnected['win'],
                                    'nulle' => $userInfoConnected['nulle'], 
                                    'loose' => $userInfoConnected['loose']];
        $_SESSION['tour'] = 0;
        $_SESSION['choix_bender'] = [];
        $_SESSION['compteur_choix'] = ['pierre' => 0, 'papier' => 0, 'ciseaux' => 0];
        
    } else {
        echo "Impossible de récupérer les infos de l'utilisateur connecté";
        print_r($sth->errorInfo());
    }
}

/* Fonction pour créer un compte dans la BDD */

function creation_compte($dbh, $infosCompte){
    $sth = $dbh->prepare("INSERT INTO utilisateurs(pseudo, email, password) VALUES (:pseudo, :email, :password);
                        INSERT INTO utilisateurs_has_avatar(id_utilisateurs, id_avatar) VALUES (LAST_INSERT_ID(), :id_avatar);
                        INSERT INTO stats(id_user, creation_compte) VALUES (LAST_INSERT_ID(), CURRENT_TIMESTAMP);");
    $isNotError = $sth->execute($infosCompte);
    // Ici on créer un utilisateur dans la table "utilisateurs" et on associe sa clef étrangère dans la table stats
    if ($isNotError) {
        echo "<script>alert('Le compte a bien été créé')</script>";
    } else {
        echo "<script>alert('Erreur lors de la création du compte')</script>";
    };
}

/* Enregistre la date et l'heure de la première partie depuis que l'utilisateur s'est connecté */

function date_first_game($dbh){
    $sth = $dbh->prepare('UPDATE stats
                INNER JOIN utilisateurs ON utilisateurs.id = stats.id_user 
                SET date_first_game = (CURRENT_TIMESTAMP)
                WHERE pseudo = :pseudo;');
    $sth->execute(['pseudo' => $_SESSION['pseudo']]);
}

/* Tout les disponibles sont récupérés afin de les afficher lorsque l'utilisateur s'inscrit */

function array_avatars($dbh){
    $sth = $dbh->prepare('SELECT id, nom, image FROM avatar;');
    $isNotError = $sth->execute();
    $avatar_profile = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $avatar_profile;
}

/* Récupération de toutes les données pour le tableau des scores */

function recuperation_scoreboard($dbh){
    $sth = $dbh->prepare('SELECT pseudo, avatar.image, stats.win, stats.loose, stats.nulle
                    FROM utilisateurs
                    INNER JOIN utilisateurs_has_avatar ON utilisateurs.id = utilisateurs_has_avatar.id_utilisateurs
                    INNER JOIN avatar ON avatar.id = utilisateurs_has_avatar.id_avatar
                    INNER JOIN stats ON utilisateurs.id = stats.id_user
                    ORDER BY stats.win DESC
                    LIMIT 10');
    $sth->execute();
    $scoreboard = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $scoreboard;
}

