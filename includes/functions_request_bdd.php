<?php

/* Vérification si les joueur est connecté */

function userConnected()
{
    if (isset($_SESSION['pseudo']) && isset($_SESSION['image'])) {
        return true;
    } else {
        return false;
    }
}

/* Récupère toutes les informations sur l'utilisateur lorsqu'il se connecte */

function users_infos($dbh, $userInfoLogin)
{
    $sth = $dbh->prepare("SELECT user.id, avatar_id, pseudo, email, avatar.image, wins, looses, nuls
                    FROM user
                    INNER JOIN avatar ON avatar.id = user.avatar_id
                    WHERE user.email=:email;");
    $isNotError = $sth->execute(['email' => $userInfoLogin['email']]);
    $userInfoConnected = $sth->fetch(PDO::FETCH_ASSOC);
    if ($isNotError) {
        $_SESSION['pseudo'] = $userInfoConnected['pseudo'];
        $_SESSION['image'] = $userInfoConnected['image'];
        $_SESSION['email'] = $userInfoConnected['email'];
        $_SESSION['id'] = $userInfoConnected['id'];
        $_SESSION['avatar_id'] = $userInfoConnected['avatar_id'];
        $_SESSION['stats_user'] = [
            'wins' => $userInfoConnected['wins'],
            'nuls' => $userInfoConnected['nuls'],
            'looses' => $userInfoConnected['looses']
        ];
        $_SESSION['tour'] = 0;
        $_SESSION['choix_bender'] = [];
        $_SESSION['compteur_choix'] = ['pierre' => 0, 'papier' => 0, 'ciseaux' => 0];
        $_SESSION['userPos'] = userPosition($dbh);
    } else {
        echo "Impossible de récupérer les infos de l'utilisateur connecté";
        print_r($sth->errorInfo());
    }
}

/* Fonction pour créer un compte dans la BDD */

function creation_compte($dbh, $infosCompte)
{
    $sth = $dbh->prepare("INSERT INTO user(pseudo, email, password, avatar_id) VALUES (:pseudo, :email, :password, :id_avatar);");
    $isNotError = $sth->execute($infosCompte);
    // Ici on créer un utilisateur dans la table "utilisateurs" et on associe sa clef étrangère dans la table stats
    if ($isNotError) {
        echo "<script>openForm('felicitation')</script>";
    } else {
        echo "<script>alert('Erreur lors de la création du compte')</script>";
    };
}

/* Enregistre la date et l'heure de la première partie depuis que l'utilisateur s'est connecté */

function date_first_game($dbh)
{
    $sth = $dbh->prepare('UPDATE user 
                SET date_first_game = (CURRENT_TIMESTAMP)
                WHERE pseudo = :pseudo;');
    $sth->execute(['pseudo' => $_SESSION['pseudo']]);
}

/* Tout les disponibles sont récupérés afin de les afficher lorsque l'utilisateur s'inscrit */

function array_avatars($dbh)
{
    $sth = $dbh->prepare('SELECT id, name, image FROM avatar;');
    $isNotError = $sth->execute();
    $avatar_profile = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $avatar_profile;
}

/* Récupération de toutes les données pour le tableau des scores */

function recuperation_scoreboard($dbh)
{
    $sth = $dbh->prepare('SELECT pseudo, avatar.image, wins, looses, nuls
                    FROM user
                    INNER JOIN avatar ON user.avatar_id = avatar.id
                    ORDER BY user.wins DESC
                    LIMIT 10');
    $sth->execute();
    $scoreboard = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $scoreboard;
}

/* On vérifie ici si le pseudo saisie par l'utilisateur existe déjà dans la BDD */

function isPseudoExist($dbh)
{
    $sth = $dbh->prepare("SELECT pseudo FROM user WHERE pseudo=:pseudo");
    $sth->execute(['pseudo' => $_POST['pseudo']]);
    $pseudoAlreadyExist = $sth->fetch(PDO::FETCH_ASSOC);
    return $pseudoAlreadyExist;
}

/* On vérifie ici si l'email saisie par l'utilisateur existe déjà dans la BDD */

function isEmailExist($dbh)
{
    $sth = $dbh->prepare("SELECT email FROM user WHERE email=:email");
    $sth->execute(['email' => strtolower($_POST['email'])]);
    $emailAlreadyExist = $sth->fetch(PDO::FETCH_ASSOC);
    return $emailAlreadyExist;
}

function userPosition($dbh)
{
    $sth = $dbh->prepare("SELECT rank FROM userrank WHERE id=:id");
    $sth->execute(['id' => $_SESSION['id']]);
    $pos = $sth->fetch(PDO::FETCH_ASSOC);
    return $pos;
}
