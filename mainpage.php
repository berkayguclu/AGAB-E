<?php
    session_start();
    require_once "dbconfig.php";
    date_default_timezone_set('Europe/Istanbul');

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
    <title>AGAB-E | MAİN PAGE</title>
    <link rel="stylesheet" href="./css/mainpage.css">
</head>
<body>
    <nav class="nav"><h1>AGAB-E</h1>
        <div class="dropdown">
            <?php echo "<h2 class='dropbtn'>" . htmlspecialchars($_SESSION["username"]) . "</h2>";?>
            <div class="dropdown-content">
              <a href="./dersler.php">Anasayfa</a>
            <?php
                if($_SESSION["auth"]==1){
                    echo "<a href='./panel.php'>Yönetim Paneli</a>";
                    echo "<a href='#'>Oluştur</a>";
                }
            ?>
              <a href="./logout.php">Çıkış yap</a>
              <!-- <a href="#">Link 3</a> -->
            </div>
          </div>
    </nav>
    <section class="sol">
        <h1>Dosyalarım</h1>
        <h3>Hafta 2 / 2022-04-02</h3>
        <div class="container">
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a><a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a><a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>
            </div></a>
        </div>
        <h3>Hafta 1 / 2022-03-25</h3>
        <div class="container">
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a><a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a><a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>
            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>
            </div></a>

        </div>



    </section>

    <section class="sag">
        <?php
            if($_SESSION["auth"]==1){
                echo "<h1>Öğrenci Dosyaları</h1>";
            } else {
                echo "<h1>Yönetici Dosyaları</h1>";
            }
        ?>
        <h3>Hafta 3 / 2022-04-09</h3>
        <div class="container">
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a><a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>
            </div></a>
        </div>
        <h3>Hafta 2 / 2022-04-02</h3>
        <div class="container">
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a><a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a><a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>
            </div></a>
        </div>
        <h3>Hafta 1 / 2022-03-25</h3>
        <div class="container">
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a><a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a><a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>
            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
            <a class="dersler1" href="#"> <div style="text-align:center">
                <img src="./img/file.png" alt="">
                <h2>sunucu yönetimi dersi hakkun</h2>

            </div></a>
        </div>
    </section>
    <section class="up">
        <p>Dosyalarınızı buraya <b>sürükleyin ve bırakın</b><br>
            ya da<br>
         <b>bir Dosya seçin.</b><p>
<!--
        Dosyalarınızı buraya &nbsp; <b> sürükleyin ve bırakın&nbsp; </b>
            ya da &nbsp;
            <b>bir Dosya seçin.</b>
    -->
    </section>
</body>
</html>
