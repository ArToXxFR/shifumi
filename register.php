<?php

require "connect_bdd.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sth = $dbh->prepare("SELECT email FROM utilisateurs WHERE email=:email");
    $isNotError = $sth->execute(['email' => strtolower($_POST['email'])]);
    if(!$isNotError){echo "Impossible de récupérer l'email";};
    $emailAlreadyExist = $sth->fetch(PDO::FETCH_ASSOC);
    $sth = $dbh->prepare("SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo");
    $isNotError = $sth->execute(['pseudo' => $_POST['pseudo']]);
    if(!$isNotError){echo "Impossible de récupérer le pseudo";};
    $passwordAlreadyExist = $sth->fetch(PDO::FETCH_ASSOC);
    // On cherche si le pseudo ou l'email est déjà présent dans la base de donnée
    if(!$emailAlreadyExist){
        if(!$passwordAlreadyExist){
            if($_POST['password'] === $_POST['confirmPassword']){
                // Quand on arrive ici, il n'y a pas d'email déjà enregistrée(majuscules comprises) ni de pseudo et les deux mots de passes enregistrés sont les mêmes
                $grain = "erwann";
                $sel = "stpun20/20";
                $password = password_hash($grain.$_POST['password'].$sel, PASSWORD_ARGON2ID);
                // Ici le mot de passe a été crypté avec la methode ARGON2ID avec un grain de sel ce qui rend la sécurité maximale
                $infosCompte = ['pseudo' => $_POST['pseudo'],
                                'email' => strtolower($_POST['email']),
                                'password' => $password,
                ];
                $sth = $dbh->prepare("INSERT INTO utilisateurs(pseudo, email, password) VALUES (:pseudo, :email, :password);
                INSERT INTO utilisateurs_has_avatar(id_utilisateurs, id_avatar) VALUES (LAST_INSERT_ID(), 1);
                INSERT INTO stats(id_user) VALUES (LAST_INSERT_ID());");
                $isNotError = $sth->execute($infosCompte);
                // Ici on créer un utilisateur dans la table "utilisateurs" et on associe sa clef étrangère dans la table stats
                if($isNotError){ echo "Le compte a bien été créer";} else { echo "Erreur lors de la création du compte";};
            } else {
                echo "Les deux mots de passe ne correspondent pas";
            }
        } else {
            echo "Pseudo déjà utilisée";
        }
    } else {
        echo "Adresse email déjà utilisée";
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
</head>
<body>
    <form action="register.php" method="POST">
        <input type="email" name="email" placeholder="Adresse email..." maxlength="255" required>
        <input type="text" name="pseudo" placeholder="Pseudo" maxlength="25" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="password" name="confirmPassword" placeholder="Confirmer le mot de passe" required>
        <input type="submit" name="button-register" value="S'enregistrer">
        <a href="index.php">Home</a>
    </form>
</body>
</html>