<?php
    session_start();
    require_once "dbconfig.php";
    $ownedFiles = $othersFiles = array();

    echo 'You are welcome ' . htmlspecialchars($_SESSION["username"]);
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    if($_SESSION["auth"]==1){
        $id = $_SESSION["id"];
        $sql = "SELECT users.username ,files.filename, files.created_at FROM users, files WHERE users.id = files.owner_id AND (users.id = $id OR users.auth = 0 )";
    } else{
        $id = $_SESSION["id"];
        $sql = "SELECT users.username ,files.filename, files.created_at FROM users, files WHERE users.id = files.owner_id AND (users.id = $id OR users.auth = 1)";
    }

    $result = mysqli_query($conn, $sql);
    if(!empty($result)){
        while ($row = mysqli_fetch_assoc($result)){
            if($row["username"]==$_SESSION["username"]){
                $line = $row["filename"] . "  |  " . $row["created_at"] . "<br>";
                array_push($ownedFiles, $line);
            } else{
                $line = $row["username"] . "  |  " . $row["filename"] . "  |  " . $row["created_at"] . "<br>";
                array_push($othersFiles, $line);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <?php
        if(!empty($ownedFiles)){
            echo "<h2>Your Files</h2>";
            echo "<h4>Filename | Upload time</h4>";
            foreach($ownedFiles as $line){
                echo $line;
            }
        }
        if(!empty($othersFiles)){
            echo "<h2>Others Files</h2>";
            echo "<h4>Username | Filename | Upload time</h4>";
            foreach($othersFiles as $line){
                echo $line;
            }
        }
    ?>
<!--
    #    if(mysqli_num_rows($result)>0){
     #       while ($row = mysqli_fetch_assoc($result)){
    #            printf("%s    %s  |   %s\n", $row["username"], $row["filename"], $row["created_at"]);
    #        }
    #    }
-->
    <h2>UPLOAD FILE FROM HERE</h2>
    <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="upload" />
        <input type="submit" value="Upload">
    </form>
    <?php
     if(isset($_SESSION["uploaded"])){
        echo "<br>" . $_SESSION["uploaded"];
    }
    ?>
    <hr>
    <a href="/logout.php"><h3>Log OUT!</h3></a>
</body>
</html>
