<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once(__DIR__ . '/config/dbConnection.php');

/*********CRUD functions *************/
function selectData($sql)
{
    global $conn;
    $sth = $conn->prepare($sql);
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

function selectDataLim($sql, $lim)
{
    global $conn;
    $sth = $conn->prepare($sql);
    $sth->bindValue(':lim', $lim, PDO::PARAM_INT);
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}


/***********Pagination Function***********/
function getPagination($table)
{
    $limit = 4;
    $sql = "SELECT COUNT(*) FROM $table";
    $data = selectData($sql);

    foreach ($data as $value) {
        $total_records = $value['COUNT(*)'];
    }

    return ceil($total_records / $limit);
}

function getImage($img, $name)
{
    if ($img == "") {
        $resName = substr($name, 0, 1);
    } else {
        /* $supported_image = array(
             'gif',
             'jpg',
             'jpeg',
             'png'
         );

         $src_file_name = $img;
         $ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
         if (in_array($ext, $supported_image)) {
             echo "it's image";
         } else {
             echo 'not image';
         }*/
        $resName = "<img src='./images/" . $img . "' alt='img' width='50' />";
    }
    return $resName;
}

// random
function randomColor()
{
    $a = array("round", "round round-success", "round round-primary", "round round-warning", "round round-danger");
    $random_keys = array_rand($a, 1);
    return $a[$random_keys];
}

function getData($table, $name, $order, $limit, $start_from) {
    $query = "select $table.* 
                        from 
                            (select * 
                             from $table  
                             order by $name desc limit $start_from, $limit) $table
                        
                        order by $name  $order";
    return $query;
}

/*function getDataRet($is_sort, $table, $name, $limit) {

    if (!isset($_GET[$is_sort])) {
        $query = getData($table, $name, 'desc', $limit);
    } else {
        $url = explode("?", $_SERVER["REQUEST_URI"])[1];
        $r = explode("=", $url)[1];
        switch ($r) {
            case 1 :
                $value = 0;
                $query = getData($table, $name, 'desc', $limit);
                break;
            case 0 :
                $value = 1;
                $query = getData($table, $name, 'asc', $limit);
                break;
        }
    }
    return $query;
}*/

//print_r(getImage('', "behruz"));
