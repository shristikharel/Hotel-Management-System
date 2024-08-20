<?php
include_once("top.php");
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'phphotel'; 

// Create a connection
$con = new mysqli($host, $username, $password, $database);

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>
