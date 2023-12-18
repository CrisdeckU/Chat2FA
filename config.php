<?php

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID | Copiar "ID DE CLIENTE"
$google_client->setClientId('419573436696-1urnv0s8lsotrfvql9udeolvv9hepkq9.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI | URL AUTORIZADO
$google_client->setRedirectUri('http://localhost/loging/try.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

//Conexión a la BDD
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "chat";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
  echo "Database connection error" . mysqli_connect_error();
}



?>