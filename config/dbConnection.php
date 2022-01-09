<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "dushamovOne_student_management_system_mini_functional";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName",$username, $password);
} catch(PDOException $e){
    echo "Bazaga ulana olmadi: " . $e->getMessage();
}
