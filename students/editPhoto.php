<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../config/dbConnection.php');
global $conn;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
}
    if (isset($_FILES['image'])) {
        $img_file = "images/";
        if (!is_dir($img_file))
            mkdir($img_file);
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_format_arr = explode(".", $file_name);
        $file_ext = strtolower(end($file_format_arr));
        $extensions = array("jpg", "jpeg", "png");
        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "Fayl formati jpg yoki png bo'lishi kerak";
        }

        if ($file_size > 2097152) {
            $errors[] = "Fayl xajmi 2mb dan katta bo'lmasligi kerak";
        }

        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, $img_file.$file_name);
            echo "Yuklandi";
        }
        else {
            print_r($errors);
        }

        $sql = "update students set image = :image where id = :id";
        $state = $conn->prepare($sql);
        $state->bindValue(':image', $file_name);
        $state->bindValue(':id', $id);

        if ($state->execute()) {
            $host = 'http://' . $_SERVER['HTTP_HOST'] . '/project_1/students/edit.php?id='.$id;
            echo "<script> window.location.replace('$host') </script>";
        } else {
            print_r($state->errorInfo());
            die();
        }


    }
