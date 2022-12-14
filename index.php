<?php session_start(); 

require "connect_bdd.php";

$sth = $dbh->prepare("SELECT image FROM avatar WHERE nom='music-bender';");
$sth->execute();
$image = $sth->fetch(PDO::FETCH_ASSOC);
var_dump($image);






?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shifumi</title>
</head>
<body>
    <?php if(isset($_SESSION['login']) && isset($_SESSION['password'])){
            echo "<a href='deconnection.php'>Se déconnecter</a>";
        } else { 
            echo "<a href='login.php'>Se connecter</a>";
        } ?>
        <img src="<?= $image['image']?>" alt="avatar" width="100px">
        <!-- pour l'instant les avatar sont fonctionnels mais à la main -->
</body>
</html>

<?php