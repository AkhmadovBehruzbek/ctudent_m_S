<?php
require_once('../config/dbConnection.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
}

$sql = 'UPDATE students SET `status`=:status WHERE id = :id';
$state = $conn->prepare($sql);
$state->bindValue(":id", $id);
$state->bindValue(":status", 'deleted');
if ($state->execute()) {
    $host = 'http://' . $_SERVER['HTTP_HOST'] . '/dushamov/project_1/students/index.php';
    echo "<script> window.location.replace('$host') </script>";
} else {
    print_r($state->errorInfo());
    die();
}