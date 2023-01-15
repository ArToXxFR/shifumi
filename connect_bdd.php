<?php 

require_once __DIR__ . "/vendor/autoload.php";
$dotenv = \Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();
$hostname = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
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
