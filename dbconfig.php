<?php
$dbServer = '<server>';
$dbUser = '<user>';
$dbPass = '<pass>';
$dbName = '<database>';

$conn = mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);
if (!($conn)){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>