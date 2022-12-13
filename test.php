<?php 

require "connect_bdd.php";

 echo "cool";

 echo "aurevoir";

 echo password_hash('admin', PASSWORD_DEFAULT);

 $sth = $dbh->prepare("SELECT * FROM utilisateurs");
 $sth->execute();

 $test = fetchAll();
