<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php require "includes/header.php"; ?>
    <div class="page_container_404">
        <h1>Erreur 404</h1>
        <span>La page que vous cherchez semble introuvable.</span>
    </div>
    <button onclick="document.location.href='index.php'">Revenir à la page d'accueil</button>
    <button onclick="document.location.href='javascript:history.go(-1)'">Revenir à la page précédente</button>
    <img src="medias/bender_message/bender_404.png" class="" alt="Bender 404">
</body>
</html>