<?php
    session_start();
    require_once "dbconfig.php";
    date_default_timezone_set('Europe/Istanbul');
    $ownedFiles = $othersFiles = array();

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    echo 'You are welcome ' . htmlspecialchars($_SESSION["username"]);

    $id = $_SESSION["id"];
    $timeCheck=time()-300;
    $time=date("Y-m-d H:i:s",$timeCheck+600);

    $sql="UPDATE users SET last_active='$time' WHERE id = $id";
    $run = mysqli_query($conn, $sql);


    if($_SESSION["auth"]==1){
        $sql = "SELECT users.username ,files.filename, files.created_at FROM users, files WHERE users.id = files.user_id AND (users.id = $id OR users.auth = 0 )";
    } else{
        $sql = "SELECT users.username ,files.filename, files.created_at FROM users, files WHERE users.id = files.user_id AND (users.id = $id OR users.auth = 1)";
    }
    $result = mysqli_query($conn, $sql);

    if(!empty($result)){
        while ($row = mysqli_fetch_assoc($result)){
            if($row["username"]==$_SESSION["username"]){
                $line =  $row["filename"] . "  |  " . $row["created_at"] . " <a href='uploads/" . $row["filename"] . "'>Download </a><br>";
                array_push($ownedFiles, $line);
            } else{
                $line = $row["username"] . "  |  " . $row["filename"] . "  |  " . $row["created_at"] . " <a href='uploads/" . $row["filename"] . "'>Download </a><br>";
                array_push($othersFiles, $line);
            }
        }
    }

    function get_time_ago( $time ){
        $time_difference = time() - $time;

        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<body>
    <?php
        echo "<hr>";
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
        echo "<hr>";
    ?>

    <h2>UPLOAD FILE FROM HERE</h2>
    <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="upload" />
        <input type="submit" value="Upload">
    </form>
    <?php
    if(isset($_SESSION["uploaded"])){
        echo "<br>" . $_SESSION["uploaded"];
    }

    echo "<hr>";

    if($_SESSION["auth"]==1){
        echo "<h3>USERS</h3>";
        $sql = "SELECT username,last_active FROM users WHERE auth = 0 ORDER BY last_active DESC";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)){
            if (strtotime($row["last_active"])>$timeCheck){
                echo $row["username"] . " |  Online now<br>";
            } else {
                echo $row["username"] . ' | ' . get_time_ago(strtotime($row["last_active"])) . "<br>";
            }
        }
        echo "<hr>";
    }
    ?>
    <a href="/logout.php"><h3>Log OUT!</h3></a>

    <script>
    </script>
</body>
</html>
