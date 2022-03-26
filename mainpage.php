<?php
    session_start();
    echo 'You are welcome ' . htmlspecialchars($_SESSION["username"]);
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <a href="/logout.php"><h3>Log OUT!</h3></a>
</body>
</html>
