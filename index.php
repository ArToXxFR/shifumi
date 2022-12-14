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
    <?php if(isset($_SESSION['pseudo']) && isset($_SESSION['image'])){
            echo "<a href='deconnection.php'>Se déconnecter</a><br/>";
            echo "Bonjour, ". $_SESSION['pseudo']; ?>
            <img src="<?= $_SESSION['image'] ?>" alt='avatar' width="100px">; <?php
        } else { 
            echo "<a href='login.php'>Se connecter</a>";
        } ?>
</body>
</html>

<?php