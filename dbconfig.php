<?php
$dbServer = '<DB_IP>';
$dbUser = '<USER>';
$dbPass = '<PASS>';
$dbName = '<DB_NAME>';

$conn = mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);
if (!($conn)){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
