<?php
$host = 'localhost'; // Replace with your database host
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$database = 'phphotel'; // Replace with your database name

// Create a connection
$con = new mysqli($host, $username, $password, $database);

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// No need to print anything when the connection is successful
?>
