<!DOCTYPE html>
<html lang="fr">

<?php session_start();

require_once __DIR__ . "/connect_bdd.php";
require_once __DIR__ . "/includes/constants.php";
require_once __DIR__ . "/includes/functions_request_bdd.php";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    /* On vérifie si l'utilisateur n'est pas déjà connecté */

    if (!userConnected()) {

        /* On vérifie que le formulaire soit un login et non pas un register */

        if ($_POST['name'] == 'login') {
            $login = [
                'username' => $_POST['username'],
                'email' => $_POST['username'],
            ];

            /* L'utilisateur a saisi une email et on récupère le pseudo et le mot de passe même si il est incorrect */

            $sth = $dbh->prepare("SELECT pseudo, password, email FROM user WHERE pseudo=:username OR email=:username");
            $isNotError = $sth->execute($login);
            $userInfoLogin = $sth->fetch(PDO::FETCH_ASSOC);

            /* On vérifie ici si il a trouvé un utilisateur dans la BDD avec le pseudo que l'utilisateur a saisi */

            if ($userInfoLogin) {

                /* On vérifie que le mot de passe corresponde bien alors celui de l'utilisateur */

                if (password_verify(GRAIN . $_POST['password'] . SEL, $userInfoLogin['password'])) {
                    /* Cette fonction va récupérer toutes les informations de l'utilisateur qui vient de se connecter
                       pseudo, avatar, nombre de wins, looses, nulls
                       Tout est stocké dans la variable superglobal _SESSION */

                    users_infos($dbh, $userInfoLogin);
                } else {
                    echo "<script>alert('Login ou mot de passe incorrect')</script>";

                    $incorrectId = true;
                }
            } else {
                //Le pseudo ou l'adresse email n'a pas été trouvé dans la base de données
                echo "<script>alert('Login ou mot de passe incorrect')</script>";
                $incorrectId = true;
            }

            /* On vérifie que le formulaire soit un register et non pas un login */
        } else if ($_POST['name'] == 'register') {

            $pseudoAlreadyExist = isPseudoExist($dbh);
            $emailAlreadyExist = isEmailExist($dbh);

            $sth = $dbh->prepare('SELECT id FROM avatar WHERE image=:image');
            $isNotError = $sth->execute(['image' => $_POST['avatar']]);
            $id_avatar = $sth->fetch(PDO::FETCH_ASSOC);
            if (!$isNotError) {
                echo "<script>alert('Impossible de récupérer l'avatar')</script>";
            }

            /* On cherche si le pseudo ou l'email est déjà présent dans la base de donnée */
            if (empty($emailAlreadyExist)) {
                if (empty($pseudoAlreadyExist)) {
                    if ($_POST['password'] === $_POST['confirmPassword']) {

                        /* Quand on arrive ici, il n'y a pas d'email déjà enregistrée(majuscules comprises) ni de pseudo et les deux mots de passes enregistrés sont les mêmes 
                           Ensuite le mot de passe est crypté avec la methode ARGON2ID avec un grain de sel ce qui rend la sécurité maximale */

                        $password = password_hash(GRAIN . $_POST['password'] . SEL, PASSWORD_ARGON2ID);

                        $infosCompte = [
                            'pseudo' => $_POST['pseudo'],
                            'email' => strtolower($_POST['email']),
                            'password' => $password,
                            'id_avatar' => $id_avatar['id'],
                        ];

                        /* Appel de la fonction qui va créer l'utilisateur dans la base de données */

                        creation_compte($dbh, $infosCompte);
                        echo "<script>openLoad('felicitation'); </script>";
                    } else {
                        echo "<script>alert('Les deux mots de passe ne correspondent pas')</script>";
                    }
                } else {
                    echo "<script>alert('Pseudo déjà utilisée')</script>";
                }
            } else {
                echo "<script>alert('Adresse email déjà utilisée')</script>";
            }
        }
    }
    if ($_POST['name'] == 'modification_profil') {

        $pseudoAlreadyExist = isPseudoExist($dbh);
        $emailAlreadyExist = isEmailExist($dbh);

        /* On vérifie le pseudo ou l'adresse email existent déjà dans la base de donnée
        A noter que si l'utilisateur rentre son propre pseudo ou email, 
        cela affichera que le pseudo ou email est déjà utilisé  */
        if (empty($emailAlreadyExist)) {
            if (empty($pseudoAlreadyExist)) {
                /* Si l'utilisateur a rentré un nouveau pseudo, il est modifié */
                if (!empty($_POST['pseudo'])) {
                    $sth = $dbh->prepare('UPDATE user SET pseudo=:new_pseudo WHERE pseudo=:old_pseudo');
                    $isNotError = $sth->execute([
                        'new_pseudo' => $_POST['pseudo'],
                        'old_pseudo' => $_SESSION['pseudo'],
                    ]);
                    $_SESSION['pseudo'] = $_POST['pseudo'];
                }
                /* Si l'utilisateur a rentré une nouvelle adresse email, elle est modifiée */
                if (!empty($_POST['email'])) {
                    $sth = $dbh->prepare('UPDATE user SET email=:new_email WHERE email=:old_email');
                    $isNotError = $sth->execute([
                        'new_email' => $_POST['email'],
                        'old_email' => $_SESSION['email'],
                    ]);
                    $_SESSION['email'] = $_POST['email'];
                }
                /* Si l'utilisateur a changé d'avatar, il est modifié ici */
                if (!empty($_POST['avatar'])) {
                    $sth = $dbh->prepare('UPDATE user SET avatar_id=:avatar_id WHERE pseudo=:pseudo');
                    $isNotError = $sth->execute(['avatar_id' => $_POST['avatar'], 'pseudo' => $_SESSION['pseudo']]);
                    $_SESSION['avatar_id'] = $_POST['avatar'];
                    $sth = $dbh->prepare("SELECT avatar.image
                    FROM user
                    INNER JOIN avatar ON avatar.id = user.avatar_id
                    WHERE user.email=:email;");
                    $isNotError = $sth->execute(['email' => $_SESSION['email']]);
                    $avatar = $sth->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['image'] = $avatar['image'];
                }
                if ($isNotError) {
                    echo "<script>alert('Le compte a bien été modifié')</script>";
                } else {
                    echo "<script>alert('Erreur lors de la modification du compte')</script>";
                }
            } else {
                echo "<script>alert('Pseudo déjà utilisée')</script>";
            }
        } else {
            echo "<script>alert('Adresse email déjà utilisée')</script>";
        }
    } else if ($_POST['name'] == 'delete_profil') {
        /* Ici on supprime directement le profil du joueur */
        $sth = $dbh->prepare('DELETE FROM user WHERE id=:id');
        $isNotError = $sth->execute(['id' => $_SESSION['id']]);
        if ($isNotError) {
            echo "<script>alert('Le compte a bien été supprimé')</script>";
            header('Location: deconnection.php');
        } else {
            echo "<script>alert('Erreur lors de la suppression du compte')</script>";
        }
    } else if ($_POST['name'] == 'modification_password') {

        /* On va d'abord vérifier que l'utilisateur a bien saisi deux mots de passe,
        Puis on vérifie si les deux mots de passes correspondent */

        if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
            if ($_POST['password'] === $_POST['confirmPassword']) {
                /* On hash le mot de passe avec un grain de sel puis on fait directement le requête SQL */
                $password = password_hash(GRAIN . $_POST['password'] . SEL, PASSWORD_ARGON2ID);
                $sth = $dbh->prepare('UPDATE user 
                                    SET password=:password
                                    WHERE id=:id');
                $isNotError = $sth->execute(['password' => $password, 'id' => $_SESSION['id']]);
                if ($isNotError) {
                    echo "<script>alert('Le mot de passe a bien été modifié')</script>";
                } else {
                    echo "<script>alert('Erreur lors de la modification du mot de passe')</script>";
                }
            } else {
                echo "<script>alert('Les deux mots de passe ne correspondent pas')</script>";
            }
        }
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/script.js"></script>

    <title>Shifumi</title>
</head>

<body>
    <?php require_once __DIR__ . "/includes/header.php"; ?>
    <div class="page_container">
        <div class="description">
            Défier <span class="rayures">Hal</span> Bender à SHIFUMI
        </div>
        <?php if (userConnected()) {
            if (!isset($_SESSION['already_played'])) { ?>
                <button class="open-button jaune" onclick="document.location.href='play.php'">Faire votre 1ère partie</button>
            <?php } else { ?>
                <button class="open-button jaune" onclick="document.location.href='play.php'">Retenter votre chance</button>
            <?php }
        } else { ?>
            <button class="open-button jaune" onclick="openForm('login')">Tenter votre chance</button>
        <?php } ?>
        <button class="open-button rouge-pastel" onclick="openForm('popupForm')">Rappel des règles</button>
        <div class="bender_message_homepage_first_time"></div>
    </div>
    <?php require_once __DIR__ . "/includes/footer.php";
    require_once __DIR__ . "/includes/popups.php" ?>
</body>

</html>