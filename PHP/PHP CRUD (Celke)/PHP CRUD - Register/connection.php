<?php

$host = "localhost";
$port = "3306";
$user = "root";
$password = "";
$dbname = "usuários";

//Conexão com porta:

$connection_port = new PDO("mysql:host=$host;port=$port;dbname=". $dbname, $user, $password);

//Conexão sem porta:

//$connection = new PDO("mysql:host=$host;dbname=". $dbname, $user, $password);

//$connection = new PDO("mysql:host=$host;user=$user;password=$password;dbname=$dbname");
