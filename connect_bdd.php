<?php 
	include ".env.sample";
	$options = [
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'", "PDO::ERRMODE_EXCEPTION"
	];
	try
	{
	   $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password, $options);
	}
	catch (Exception $e)
	{
	   die('Erreur : ' . $e->getMessage());
	}
?>