<?php
session_start();

if (session_id() == '' || !isset($_SESSION['login'])) {
    header('Location: ../login.php');
}

//print_r($_SERVER["REQUEST_URI"]);

require_once('../config/dbConnection.php');
require_once(__DIR__ . '/../header.php');
include('../functions.php');

if (isset($_GET['page'])) {
    $pn = $_GET['page'];
} else {
    $pn = 1;
}


$value = 0;
$limit = 4;
$start_from = ($pn - 1) * $limit;

function explodeFunc($data) {
    return(explode("-", $data));
}
if (isset($_GET["find_name"]) || isset($_GET["find_phone"]) || isset($_GET["find_address"])) {
    $findName = $_GET['find_name'];
    $query = "select students.* 
                        from 
                            (select * 
                             from students  
                             order by firstName desc limit 3) students
                        WHERE firstName LIKE '%$findName%' or lastName LIKE '%$findName%'
                        order by id  desc";
} elseif(isset($_GET["id_sort"]) || isset($_GET["phone_sort"]) || isset($_GET["address_sort"])) {
    $url = explode("?", $_SERVER["REQUEST_URI"])[1];
    $r = explode("=", $url)[1];
    switch ($r) {
        case 1 :
            $value = 0;
            $query = getData('students', 'id', 'desc', 3, $start_from);
            break;
        case 0 :
            $value = 1;
            $query = getData('students', 'id', 'asc', 3, $start_from);
            break;
    }
} else {
    $query = getData('students', 'id', 'desc', 3, $start_from);
}

$result = selectData($query);

// $limit = 4;
// $start_from = ($pn - 1) * $limit;
// $sql = "SELECT * from students WHERE students.status = 'active' LIMIT $start_from, $limit";

// $result = selectData($sql);
?>

<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Talabalar</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../index.php">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Talabalar
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <div class="text-end upgrade-btn">
                    <a href="create.php" class="btn btn-success d-none d-md-inline-block text-white">Talaba Qo'shish</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->

    <div class="container-fluid">
        <!-- Table -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex">
                            <h4 class="card-title col-md-10 mb-md-0 mb-3 align-self-center">
                                Projects of the Month
                            </h4>
                            <!--<div class="col-md-2 ms-auto">
                                <select class="form-select shadow-none col-md-2 ml-auto">
                                    <option selected>January</option>
                                    <option value="1">February</option>
                                    <option value="2">March</option>
                                    <option value="3">April</option>
                                </select>
                            </div>-->
                        </div>
                        <div class="table-responsive mt-5">
                            <table class="table stylish-table no-wrap">
                                <thead>
                                    <tr>
                                        <form name="Table Properties" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <th class="border-top-0" colspan="2">Ism Familiya
                                                <button type="submit" name="id_sort" value="<?php echo $value; ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-sort-alphabetical"></i></button>
                                            </th>
                                        </form>

                                        <form name="Table Properties" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <th class="border-top-0">Telefon raqam
                                                <button type="submit" name="phone_sort" value="<?php echo $value; ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-sort-alphabetical"></i></button>
                                            </th>
                                        </form>

                                        <form name="Table Properties" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <th class="border-top-0">Manzil
                                                <button type="submit" name="address_sort" value="<?php echo $value; ?>" class="btn btn-primary btn-sm"><i class="mdi mdi-sort-alphabetical"></i></button>
                                            </th>
                                        </form>
                                        <th class="border-top-0">action</th>
                                    </tr>
                                    <tr>
                                        <th class="border-top-0" colspan="2">
                                            <form class="app-search ps-3" method="GET">
                                                <input type="text" name="find_name" class="form-control" placeholder="Search for...">
                                                <button type="submit" class="btn"><i class="mdi mdi-magnify fs-4 lh-sm"></i></button>
                                            </form>
                                        </th>
                                        <th class="border-top-0">
                                            <form class="app-search ps-3" method="GET">
                                                <input type="text" name="find_name" class="form-control" placeholder="Search for...">
                                                <button type="submit" class="btn"><i class="mdi mdi-magnify fs-4 lh-sm"></i></button>
                                            </form>
                                        </th>
                                        <th class="border-top-0">
                                            <form class="app-search ps-3" method="GET">
                                                <input type="text" name="find_name" class="form-control" placeholder="Search for...">
                                                <button type="submit" class="btn"><i class="mdi mdi-magnify fs-4 lh-sm"></i></button>
                                            </form>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php

                                        foreach ($result as $value) {
                                            echo "<tr>
                                                    <td style='width: 50px'>
                                                        <span class='" . randomColor() . "'>" . getImage($value['image'], $value['firstName'] . $value['lastName']) . "</span>
                                                    </td>
                                                    <td class='align-middle'>
                                                        <h6>" . $value['firstName'] . ' ' . $value['lastName'] . "</h6>
                                                        <small class='text-muted'>" . $value['lastName'] . "</small>
                                                    </td>
                                                    <td class='align-middle'>" . $value['phoneNumber'] . "</td>
                                                    <td class='align-middle'>" . $value['address'] . "</td>
                                                    <td class='align-middle'>
                                                        <!-- <a href='./settings/studentsview.php'><i class='mdi mdi-eye'></i></a> -->
                                                        <a href='edit.php?id=" . $value['id'] . "'><i class='mdi mdi-account-edit'></i></a>
                                                        <a href='delete.php?id=" . $value['id'] . "'><i class='mdi mdi-delete'></i></a>

                                                    </td>
                                                </tr>";
                                        }
                                        ?>

                                        <!-- <td style="width: 50px">
                                                    <span class="round">S</span>
                                                </td>
                                                <td class="align-middle">
                                                    <h6>Sunil Joshi</h6>
                                                    <small class="text-muted">Web Designer</small>
                                                </td>
                                                <td class="align-middle">Elite Admin</td>
                                                <td class="align-middle">$3.9K</td>
                                            </tr>
                                            <tr class="active">
                                                <td>
                                                    <span class="round"><img src="./assets/images/users/2.jpg" alt="user" width="50" /></span>
                                                </td>
                                                <td class="align-middle">
                                                    <h6>Andrew</h6>
                                                    <small class="text-muted">Project Manager</small>
                                                </td>
                                                <td class="align-middle">Real Homes</td>
                                                <td class="align-middle">$23.9K</td>
                                            </tr> -->
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <?php
                                $total_pages = getPagination('students');
                                $pagLink = "<li class='page-item disabled'>
                                            <a class='page-link' href='#' tabindex='-1'> 1 - $total_pages </a>
                                        </li>";

                                for ($i = 1; $i <= $total_pages; $i++) {
                                    if ($i == $pn) {
                                        $pagLink .= "<li class='page-item'><a class='page-link active' href='index.php?page=$i'>$i</a></li>";
                                    } else {
                                        $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
                                    }
                                }
                                echo $pagLink;
                                ?>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Table -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<?php require(__DIR__ . '/../footer.php');  ?>