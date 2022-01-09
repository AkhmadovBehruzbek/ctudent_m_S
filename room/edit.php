<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../config/dbConnection.php');
require_once(__DIR__.'/../header.php'); 
include('../functions.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'];
}

$sql = "SELECT * FROM room WHERE room.id = $id LIMIT :lim";
$result = selectDataLim($sql, 1);

if (isset($_POST['room_number']) && !empty($_POST['room_number']) &&
    isset($_POST['title']) && !empty($_POST['title'])) {
    $sql = "update room set room_number = :room_number, title = :title, status=:status where id = :id";
    $state = $conn->prepare($sql);
    $state->bindValue(":room_number", $_POST['room_number']);
    $state->bindValue(":title", $_POST['title']);
    $state->bindValue(":status", $_POST['status']);
    $state->bindValue(":id", $id);
    if ($state->execute()) {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/dushamov/project_1/room/index.php';
        echo "<script> window.location.replace('$host') </script>";
    } else {
        print_r($state->errorInfo());
        die();
    }

}

?>
<div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
  <!-- Page wrapper  -->
  <!-- ============================================================== -->
  <div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
      <div class="row align-items-center">
        <div class="col-md-6 col-8 align-self-center">
          <h3 class="page-title mb-0 p-0">Kursni o'zgartirish</h3>
          <div class="d-flex align-items-center">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Kursni o'zgartirish
                </li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="col-md-6 col-4 align-self-center">
          <div class="text-end upgrade-btn">
            <a href="https://www.wrappixel.com/templates/monsteradmin/" class="btn btn-success d-none d-md-inline-block text-white" target="_blank">Upgrade to Pro</a>
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
      <!-- ============================================================== -->
      <!-- Start Page Content -->
      <!-- ============================================================== -->
      <!-- Row -->
      <div class="row">
        <div class="col-lg-8 col-xlg-9 col-md-7">
          <div class="card">
            <div class="card-body">

              <?php


              ?>
              <form class="form-horizontal form-material mx-2" method="POST">
                <?php foreach ($result as $value) { ?>
                  <div class="form-group">
                    <label class="col-md-12 mb-0">Kurs nomi</label>
                    <div class="col-md-12">
                      <input name="room_number" value="<?= $value['room_number']; ?>" type="text" class="form-control ps-0 form-control-line" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 mb-0">Kurs haqida</label>
                    <div class="col-md-12">
                      <input name="title" value="<?= $value['title']; ?>" type="text"  class="form-control ps-0 form-control-line" />
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-12">Statusi</label>
                    <div class="col-sm-12 border-bottom">
                      <select name="status" class="
                            form-select
                            shadow-none
                            border-0
                            ps-0
                            form-control-line
                          ">
                        <option selected><?= $value['status']; ?></option>
                        <?php
                        if ($value['status'] == 'active') {
                          echo "<option value='inactive'>inactive</option>";
                        } else {
                          echo "<option value='active'>active</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                <?php } ?>

                <!-- <div class="form-group">
                      <label class="col-md-12 mb-0">Password</label>
                      <div class="col-md-12">
                        <input
                          type="password"
                          value="password"
                          class="form-control ps-0 form-control-line"
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-12 mb-0">Phone No</label>
                      <div class="col-md-12">
                        <input
                          type="text"
                          placeholder="123 456 7890"
                          class="form-control ps-0 form-control-line"
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-12 mb-0">Message</label>
                      <div class="col-md-12">
                        <textarea
                          rows="5"
                          class="form-control ps-0 form-control-line"
                        ></textarea>
                      </div>
                    </div> -->

                <div class="form-group">
                  <div class="col-sm-12 d-flex">
                    <input name="update" value="Yangilash" type="submit" class="btn btn-success mx-auto mx-md-0 text-white">
                    <!-- Yangilash -->
                    <!-- </button> -->
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Column -->
      </div>
      <!-- Row -->
      <!-- ============================================================== -->
      <!-- End PAge Content -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Right sidebar -->
      <!-- ============================================================== -->
      <!-- .right-sidebar -->
      <!-- ============================================================== -->
      <!-- End Right sidebar -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->


    
    <?php require(__DIR__.'/../footer.php');  ?>
  </div>