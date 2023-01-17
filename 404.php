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
    <div class="page_container page_container_404">
        <h1>Erreur 404</h1>
        <p>La page que vous cherchez semble introuvable.</p>
        <button onclick="document.location.href='index.php'" class="jaune">Revenir à la page d'accueil</button>
        <button onclick="document.location.href='javascript:history.go(-1)'" class="rouge-pastel">Revenir à la page précédente</button>
        <div class="bender_message_404"></div>
    </div>
</body>

</html>