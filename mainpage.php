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

    if($_GET["course"]){
        $courseId=$_GET["course"];
    } else{
        header("location: dersler.php");
        exit;
    }

    if($_SESSION["auth"]==1){
        $sql = "SELECT id, course_name FROM courses WHERE owner_id = $id";
    } else{
        $sql = "SELECT id, course_name FROM courses WHERE id IN (SELECT course_id FROM enroll_courses WHERE user_id = $id)";
    }
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)){
        if($courseId==$row["id"]){
            $courseName=$row["course_name"];
            $_SESSION["course_id"]=$courseId;
        }
    }

    if(!isset($courseName)){
        header("location: dersler.php");
        exit;
    }

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
    <nav class="nav">
        <h1>AGAB-E</h1>
        <?php echo "<p>" . $courseName . "</p>"; ?>
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

<?php
    $sql = "SELECT users.username ,files.filename, files.created_at FROM users, files WHERE users.id = files.user_id AND users.id = $id AND course_id = $courseId ORDER BY files.created_at DESC";

    $result = mysqli_query($conn, $sql);
    if(!empty($result)){
        while ($row = mysqli_fetch_assoc($result)){
            $fileDate=date("d/m/Y",strtotime($row["created_at"]));
            if(!isset($currentDate) || $currentDate!=$fileDate){
                if(isset($currentDate)){echo "</div>";}
                $currentDate=$fileDate;
                echo "<h3>" . $fileDate . "</h3>";
                echo "<div class='container'>";
                echo "<a class='dersler1' href='uploads/" . $row["filename"] . "'> <div style='text-align:center'><img src='./img/file.png' alt='filesymbol'><h2>" . $row["username"] . "<br>" . date("H:i",strtotime($row["created_at"])) . "</h2></div></a>";
            } else{
                echo "<a class='dersler1' href='uploads/" . $row["filename"] . "'> <div style='text-align:center'><img src='./img/file.png' alt='filesymbol'><h2>" . $row["username"] . "<br>" . date("H:i",strtotime($row["created_at"])) . "</h2></div></a>";
            }


        }
        echo "</div>";
    }

?>
    </section>

    <section class="sag">
<?php
    if($_SESSION["auth"]==1){
        echo "<h1>Öğrenci Dosyaları</h1>";
        $sql = "SELECT users.username ,files.filename, files.created_at FROM users, files WHERE users.id = files.user_id AND users.auth = 0 AND course_id = $courseId ORDER BY files.created_at DESC";

        $result = mysqli_query($conn, $sql);
        if(!empty($result)){
            while ($row = mysqli_fetch_assoc($result)){
                $fileDate=date("d/m/Y",strtotime($row["created_at"]));
                if(!isset($currentDateSecond) || $currentDateSecond!=$fileDate){
                    if(isset($currentDateSecond)){echo "</div>";}
                    $currentDateSecond=$fileDate;
                    echo "<h3>" . $fileDate . "</h3>";
                    echo "<div class='container'>";
                    echo "<a class='dersler1' href='uploads/" . $row["filename"] . "'> <div style='text-align:center'><img src='./img/file.png' alt='filesymbol'><h2>" . $row["username"] . "<br>" . date("H:i",strtotime($row["created_at"])) . "</h2></div></a>";
                } else{
                    echo "<a class='dersler1' href='uploads/" . $row["filename"] . "'> <div style='text-align:center'><img src='./img/file.png' alt='filesymbol'><h2>" . $row["username"] . "<br>" . date("H:i",strtotime($row["created_at"])) . "</h2></div></a>";
                }


            }
            echo "</div>";
        }

    } else {
        echo "<h1>Yönetici Dosyaları</h1>";
        $sql = "SELECT users.username ,files.filename, files.created_at FROM users, files WHERE users.id = files.user_id AND users.auth = 1 AND course_id = $courseId ORDER BY files.created_at DESC";

        $result = mysqli_query($conn, $sql);
        if(!empty($result)){
            while ($row = mysqli_fetch_assoc($result)){
                $fileDate=date("d/m/Y",strtotime($row["created_at"]));
                if(!isset($currentDateSecond) || $currentDateSecond!=$fileDate){
                    if(isset($currentDateSecond)){echo "</div>";}
                    $currentDateSecond=$fileDate;
                    echo "<h3>" . $fileDate . "</h3>";
                    echo "<div class='container'>";
                    echo "<a class='dersler1' href='uploads/" . $row["filename"] . "'> <div style='text-align:center'><img src='./img/file.png' alt='filesymbol'><h2>" . $row["username"] . "<br>" . date("H:i",strtotime($row["created_at"])) . "</h2></div></a>";
                } else{
                    echo "<a class='dersler1' href='uploads/" . $row["filename"] . "'> <div style='text-align:center'><img src='./img/file.png' alt='filesymbol'><h2>" . $row["username"] . "<br>" . date("H:i",strtotime($row["created_at"])) . "</h2></div></a>";
                }


            }
            echo "</div>";
        }

    }
?>
    </section>
    <section class="up" id=drag-drop>
        <div>
        <p>Dosyalarınızı buraya <b>sürükleyin ve bırakın</b><br>
            ya da<br><p>
        <p><input type="button" value="Dosya seçin." onclick="file_explorer();" /></p>
        <input type="file" id="selectfile" style="display:none;" onchange="handleFiles(this.files)" />
        </div>
</section>


<script>
console.log("naber");

let dropArea = document.getElementById('drag-drop');

;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
  dropArea.addEventListener(eventName, preventDefaults, false)
})

function preventDefaults (e) {
  e.preventDefault()
  e.stopPropagation()
}
;['dragenter', 'dragover'].forEach(eventName => {
  dropArea.addEventListener(eventName, highlight, false)
})

;['dragleave', 'drop'].forEach(eventName => {
  dropArea.addEventListener(eventName, unhighlight, false)
})

function highlight(e) {
  dropArea.classList.add('highlight')
}

function unhighlight(e) {
  dropArea.classList.remove('highlight')
}

dropArea.addEventListener('drop', handleDrop, false)

function handleDrop(e) {
  let dt = e.dataTransfer
  let files = dt.files

  handleFiles(files)
}

function handleFiles(files) {
  ([...files]).forEach(uploadFile)
}


var fileobj;

function file_explorer() {
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function() {
        fileobj = document.getElementById('selectfile').files[0];
        uploadFile(fileobj);
    };
}

function uploadFile(file) {
  let url = 'upload.php'
  let formData = new FormData()

  formData.append('upload', file)

  fetch(url, {
    method: 'POST',
    body: formData
  })
  .then(() => { location.reload() })
  .catch(() => { alert("yok") })
}


</script>
</body>
</html>
