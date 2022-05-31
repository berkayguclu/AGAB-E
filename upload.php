<?php
require_once "dbconfig.php";
session_start();

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!empty($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {
        if (is_uploaded_file($_FILES['upload']['tmp_name']) === false) {
            throw new \Exception('Error on upload: Invalid file definition');
        }

        $uploadName = $_FILES['upload']['name'];
        $ext = strtolower(substr($uploadName, strripos($uploadName, '.')+1));
        $filename = $_SESSION["username"].date('d-m-y-').mt_rand().round(microtime(true)).'.'.$ext;


        $sql = "INSERT INTO files (user_id, course_id, filename) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_user, $param_course_id, $param_filename);

            $param_user = $_SESSION["id"];
            $param_course_id = $_SESSION["course_id"];
            $param_filename = $filename;

            if(mysqli_stmt_execute($stmt)){
                move_uploaded_file($_FILES['upload']['tmp_name'], 'uploads/'.$filename);
                $_SESSION["uploaded"] = "UPLOADED!";
            } else {
                $_SESSION["uploaded"] = "There is some database error!";
            }
            mysqli_stmt_close($stmt);
        }


    } else {
        $_SESSION["uploaded"] = "Gev is some error!";
    }
}
mysqli_close($conn);
?>
