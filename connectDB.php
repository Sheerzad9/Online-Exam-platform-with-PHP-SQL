<?php
// DB Credentials
$DB_HOST = "127.0.0.1";
$DB_USER = "root";
$DB_PASSWORD = "";
$DB_NAME = "xamppkanta";

// Connecting db 
$dbc = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

// If error occurs, show it on screen.
if ($dbc->connect_error) {
    die("Connection failed: " . $cdbc->connect_error);
    echo "Error";
}
?>