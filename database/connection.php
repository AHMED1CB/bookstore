<?php


$config = require 'config.php';

$user = $config['user'];

$pass = $config['pass'];

$host = $config['host'];

$db = $config['database'];




// Connection
try{

	$connection = new PDO("mysql:host=$host;dbname=$db" , $user , $pass);

	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(Exception) {

    die("Connection failed: Please Try Again Later"); // On Production Dont Display Any Messages

}



