<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dersler.php");
    exit;
}

require_once "dbconfig.php";
$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["uname"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["uname"]);
    }

    if(empty(trim($_POST["pass"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["pass"]);
    }

    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, auth, student_id, username, password FROM users WHERE student_id = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $auth, $student_id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["auth"] = $auth;

                            header("location: dersler.php");
                        } else {
                            $login_err = "Yanlış parola veya kullanıcı adı girdiniz!";
                        }
                    }
                } else {
                    $login_err = "Yanlış parola veya kullanıcı adı girdiniz!";
                }
            } else {
                echo "There is some DB ERROR!";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@100&display=swap" rel="stylesheet">
</head>
<body bgcolor="#f5f5f5">
    <section class="main">
        <div class="sag">

        </div>
        <div class="sol">

        </div>
        <section class="login">
            <h2>GİRİŞ YAP!</h2>
            <?php
                if(!empty($login_err)){
                    echo '<div class="error">' . $login_err . '</div>';
                }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="container">
                  <label for="uname"><b>Kullanıcı Adı</b></label>
                  <input class="furkan" type="text" placeholder="Kullanıcı Adını Giriniz!" name="uname" required>
                  <span><?php echo $username_err; ?></span>

                  <label for="psw" class="sifre"><b>Şifre</b></label>
                  <input class="furkan" type="password" placeholder="Şifreniz Giriniz!" name="pass" required>
                  <span><?php echo $password_err; ?></span>

                  <button class="giris" type="submit">Giriş!</button>
                </div>

              </form>


            <div class="panel1">
                <section class="logo">
                    <img src="kisspng-grumpy-cat-kitten-dog-computer-icons-cats-vector-5add3d779a1414.4545438515244486316311.png" alt="">
                </section>
                <h1>AGAB-E</h1>
                <div style="text-align:center"><h3>Eğitim için Yenilikçi Çözümler <br> Üretir</h3></div>
            </div>

            <a href="#"><h4>Yardıma İhtiyacın Var Mı?</h4></a>
        </section>
    </section>
</body>
</html>
