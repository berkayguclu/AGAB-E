<?php
$dbServer = '<IP>';
$dbUser = '<DB_USER>';
$dbPass = '<DB_PASS>';
$dbName = '<DB_NAME>';

$conn = mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);
if (!($conn)){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
