<?php 

require "connect_bdd.php";

$sth = $dbh->prepare("SELECT * FROM utilisateurs");
$sth->execute();

$test = $sth->fetchAll(PDO::FETCH_ASSOC);

var_dump($test);

echo "voici la page d'accueil";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shifumi</title>
</head>
<body>
    <a href="login.php">se login</a>
</body>
</html>
