<?php
    session_start();
    require_once "dbconfig.php";
    date_default_timezone_set('Europe/Istanbul');

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }


    $id = $_SESSION["id"];
    $timeCheck=time()-300;
    $time=date("Y-m-d H:i:s",$timeCheck+600);

    $sql="UPDATE users SET last_active='$time' WHERE id = $id";
    $run = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agab-E - DERSLER</title>
    <link rel="stylesheet" href="./css/dersler.css">
</head>
<body>
    <nav class="nav">
        <h1>AGAB-E</h1>
        <div class="dropdown">
            <?php echo "<h2 class='dropbtn'>" . htmlspecialchars($_SESSION["username"]) . "</h2>";?>
            <div class="dropdown-content">
              <a href="#">Anasayfa</a>
            <?php
                if($_SESSION["auth"]==1){
                    echo "<a href='./panel.php'>Yönetim Paneli</a>";
                    echo "<a href='#'>Oluştur</a>";
                }
            ?>
              <a href="/logout.php">Çıkış yap</a>
              <!-- <a href="#">Link 3</a> -->
            </div>
          </div>
    </nav>

    <section class="main">
    <?php
        if($_SESSION["auth"]==1){
            $sql = "SELECT id, course_name FROM courses WHERE owner_id = $id";
        } else{
            $sql = "SELECT id, course_name FROM courses WHERE id IN (SELECT course_id FROM enroll_courses WHERE user_id = $id)";
        }
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)){
            echo "<a class='dersler1' href='/mainpage.php?course=" . $row["id"] . "'><div>";
            echo "<h2>" . $row["course_name"] . "</h2>";
            echo "</div></a>\n";
        }
    ?>
    </section>
</body>
</html>
