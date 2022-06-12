<?php
$dbServer = '<IP>';
$dbUser = '<USER>';
$dbPass = '<PASS>';
$dbName = '<NAME>';

$conn = mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);
if (!($conn)){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
