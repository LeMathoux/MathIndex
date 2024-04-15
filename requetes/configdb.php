<?php

$username = 'root';
$password = '';
$name = 'mathindex';
try
{
  $mysqlClient = new PDO("mysql:host=127.0.0.1; dbname=$name", $username, $password);
}
catch (Exception $e){
  die('Erreur : ' . $e->getMessage());
}
?>
