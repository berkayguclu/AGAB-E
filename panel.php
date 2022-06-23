<?php
    session_start();
    require_once "dbconfig.php";
    date_default_timezone_set('Europe/Istanbul');

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    $course_id=$_SESSION["course_id"];
    $course_name=$_SESSION["course_name"];

    $id = $_SESSION["id"];
    $timeCheck=time()-300;
    $time=date("Y-m-d H:i:s",$timeCheck+600);

    $sql="UPDATE users SET last_active='$time' WHERE id = $id";
    $run = mysqli_query($conn, $sql);

    function get_time_ago( $time ){
        $time_difference = time() - $time;

        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'yıl',
                    30 * 24 * 60 * 60       =>  'ay',
                    24 * 60 * 60            =>  'gün',
                    60 * 60                 =>  'saat',
                    60                      =>  'dakika',
                    1                       =>  'saniye'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return $t . ' ' . $str . ' önce';
            }
        }
    }

    $uname = $addp = $delp = $changep = "";
    $username_err = $password_err = $login_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["name"]))){
            $username_err = "Please enter username.";
            echo '<script>alert("Lutfen bir kullanici adi girin!");window.location = window.location.href;</script>';

        } else{
            $uname = trim($_POST["name"]);
        }

        if(empty(trim($_POST["addp"])) && empty(trim($_POST["delp"])) &&  empty(trim($_POST["changep"]))){
            $password_err = "Please enter your password.";
            echo '<script>alert("Lutfen bir parola girin!");window.location = window.location.href;</script>';
        } else{
            $addp = trim($_POST["addp"]);
            $delp = trim($_POST["delp"]);
            $changep = trim($_POST["changep"]);
        }

        if(!empty($addp)){
            $studentId = $_POST["studentId"];

            $sql = "SELECT * FROM users WHERE student_id = '$studentId'";

            $result = mysqli_query($conn, $sql);
            if(!empty($result)){
                $row = mysqli_fetch_assoc($result);
                if(!empty($row)){
                    echo '<script>alert("Bu kullanici zaten var!");window.location = window.location.href;</script>';
                } else{
                    $thepass = password_hash($addp,PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (student_id, username, password) VALUES (?, ?, ?)";

                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "sss", $param_student_id, $param_username, $param_pass);

                        $param_student_id = $studentId;
                        $param_username = $uname;
                        $param_pass = $thepass;

                        if(mysqli_stmt_execute($stmt)){
                            echo '<script>alert("Kullanici olusturuldu!");window.location = window.location.href;</script>';
                        } else{
                            echo '<script>alert("Bir sorun olustu!");window.location = window.location.href;</script>';
                        }
                        mysqli_stmt_close($stmt);
                    }
                }

            }
        } elseif(!empty($changep)){
            $sql = "SELECT auth FROM users WHERE student_id = '$uname'";

            $result = mysqli_query($conn, $sql);
            if(!empty($result)){
                $row = mysqli_fetch_assoc($result);
                if(!empty($row)){
                    if($row["auth"]==1){
                        echo '<script>alert("Bu kullanicinin parolasini degistirmeye yetkin yok!");window.location = window.location.href;</script>';
                    } else{
                        $thepass = password_hash($changep,PASSWORD_DEFAULT);

                        $sql = "UPDATE users set password = ? WHERE student_id = ?";

                        if($stmt = mysqli_prepare($conn, $sql)){
                            mysqli_stmt_bind_param($stmt, "ss", $param_pass, $param_student_id);

                            $param_pass = $thepass;
                            $param_student_id = $uname;

                            if(mysqli_stmt_execute($stmt)){
                                echo '<script>alert("Parola degistirildi!");window.location = window.location.href;</script>';
                            } else {
                                echo '<script>alert("Boyle bir kullanici yok!");window.location = window.location.href;</script>';
                            }
                            mysqli_stmt_close($stmt);
                        }
                    }
                } else{
                    echo '<script>alert("Boyle bir kullanici yok!");window.location = window.location.href;</script>';
                }
            } else {
                echo '<script>alert("Boyle bir kullanici yok!");window.location = window.location.href;</script>';
            }
        } elseif(!empty($delp)){
            $sql = "SELECT auth,password FROM users WHERE student_id = '$uname'";

            $result = mysqli_query($conn, $sql);
            if(!empty($result)){
                $row = mysqli_fetch_assoc($result);
                if(!empty($row)){
                    if($row["auth"]==1){
                        echo '<script>alert("Bu kullaniciyi silmeye yetkin yok!");window.location = window.location.href;</script>';
                    } else{
                        if(password_verify($delp,$row["password"])){

                            $sql = "DELETE FROM users WHERE student_id = ?";

                            if($stmt = mysqli_prepare($conn, $sql)){
                                mysqli_stmt_bind_param($stmt, "s", $param_student_id);

                                $param_student_id = $uname;

                                if(mysqli_stmt_execute($stmt)){
                                    echo '<script>alert("Kullanici silindi");window.location = window.location.href;</script>';
                                } else {
                                    echo '<script>alert("Boyle bir kullanici yok!");window.location = window.location.href;</script>';
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else{
                            echo '<script>alert("Parola yanlis!");window.location = window.location.href;</script>';

                        }
                    }
                } else{
                    echo '<script>alert("Boyle bir kullanici yok!");window.location = window.location.href;</script>';
                }
            } else {
                echo '<script>alert("Boyle bir kullanici yok!");window.location = window.location.href;</script>';
            }

        }

    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1"/>
    <title>AGAB-E | PANEL</title>
    <link rel="stylesheet" href="./css/panel.css">
</head>
<body>
    <nav class="nav">
        <h1>
            <?php echo "<a href='./mainpage.php?course=" . $_SESSION["course_id"]  . "' style='color:#000;'> AGAB-E</a>" ?>
        </h1>
        <?php echo "<p>" . $_SESSION["courseName"] . "</p>"; ?>
        <div class="dropdown">
            <?php echo "<h2 class='dropbtn'>" . htmlspecialchars($_SESSION["username"]) . "</h2>";?>
            <div class="dropdown-content">
              <a href="./dersler.php">Anasayfa</a>
            <?php
                if($_SESSION["auth"]==1){
                    echo "<a href='#'>Yönetim Paneli</a>";
                    echo "<a href='#'>Oluştur</a>";
                }
            ?>
              <a href="./logout.php">Çıkış yap</a>
              <!-- <a href="#">Link 3</a> -->
            </div>
          </div>
    </nav>
    <section class="sol">
        <h1>KULLANICILAR</h1>
        <ul>
            <?php
                $sql = "SELECT username,last_active FROM users WHERE auth = 0 ORDER BY last_active DESC";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)){
                    if (strtotime($row["last_active"])>$timeCheck){
                        echo "<li class='user'>" . $row["username"] . "</li>";
                        echo "<li class='status'>Aktif</li>";
                    } else{
                        echo "<li class='user'>" . $row["username"] . "</li>";
                        echo "<li class='status'>" . get_time_ago(strtotime($row["last_active"])) . "</li>";
                    }
                }
            ?>
        </ul>

    </section>
    <section class="sag">
        <div class='menu'>
            <h2 class="pasif" id="ekle" onclick="changeForm(this)">ÖĞRENCİ EKLE</h2>
            <h2 class="aktif" id="degistir" onclick="changeForm(this)">PAROLA DEĞİŞTİR</h2>
            <h2 class="pasif" id="sil" onclick="changeForm(this)">ÖĞRENCİ SİL</h2>
        </div>
        <div class="cont">
            <form class='panelForm' id="degistirForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label class="formLabel" for="degistirName">Kullanıcı Adı</label>
                <input type="text" name="name" id="degistirName" placeholder="Kullanıcı Adı">
                <label class="formLabel" for="degistirPass">Yeni Parola</label>
                <input type="password" name="changep" id="degistirPass" placeholder="Parola">
                <button>DEĞİŞTİR</button>
            </form>
            <form class='panelForm' id="ekleForm" style="display:none;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label class="formLabel" for="ekleName">Kullanıcı Adı</label>
                <input type="text" name="name" id="ekleName" placeholder="Kullanıcı Adı">
                <label class="formLabel" for="studentId">Öğrenci Numarası</label>
                <input type="text" name="studentId" id="studentId" placeholder="Öğrenci Numarası">
                <label class="formLabel" for="eklePass">Parola</label>
                <input type="password" name="addp" id="eklePass" placeholder="Parola">
                <button>EKLE</button>
            </form>
            <form class='panelForm' id="silForm" style="display:none;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label class="formLabel" for="silName">Kullanıcı Adı</label>
                <input type="text" name="name" id="silName" placeholder="Kullanıcı Adı">
                <label class="formLabel" for="silPass">Parola</label>
                <input type="password" name="delp" id="silPass" placeholder="Parola">
                <button>SIL</button>
            </form>
        </div>
    </section>

<script>
    const idList = ["ekle","degistir","sil"];
    function changeForm(element){
        element.classList.remove("pasif");
        element.classList.add("aktif");
        document.getElementById(element.id+"Form").style="display:flex;";
        idList.forEach((item) => {
            if(item!=element.id){
                document.getElementById(item).classList.remove("aktif");
                document.getElementById(item).classList.add("pasif");
                document.getElementById(item+"Form").style="display:none;";
            }
        });
    }
</script>
</body>
</html>
