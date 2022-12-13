<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="POST">
        <input name="login" type="text" placeholder="Nom d'utilisateur / Adresse e-mail">
        <input name="password" type="password" placeholder="Mot de passe...">
        <input name="button-login" type="submit" value="Se connecter">
    </form>
    <a href="register.php">Pas de compte ?</a>
</body>
</html>