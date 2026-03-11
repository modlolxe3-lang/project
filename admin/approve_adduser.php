<!-- Header. -->
<?php include("header.php"); ?>

<!-- Connect DB. -->
<?php include("condb.php"); ?>

<!-- <?php

session_start();

?> -->

<!-- DataTables -->
<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- Left Menu. -->
<?php include("left-menu.php") ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>หน้าแรก (ผู้ดูแลระบบ)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="#">หน้าแรก</a></li> -->
                        <li class="breadcrumb-item active">หน้าแรก (ผู้ดูแลระบบ)</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Start Container fluid. -->
        <div class="container-fluid">

            <!-- Start table row. -->
            <div class="row">

                <!-- Start col-12. -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="card">

                        <div class="card-header"
                            style="background:#001f3f linear-gradient(180deg,#26415c,#001f3f) repeat-x!important ;">

                            <h3 class="card-title" style="color: #ffffff;">จัดการอนุมัติผู้ใช้งานระบบ</h3>

                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <!-- <th>ID</th> -->
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>ชื่อผู้ใช้งาน</th>
                                        <th>email</th>
                                        <th>รหัสผ่าน</th>
                                        <th>สิทธิ์</th>
                                        <!-- <th>isActive</th> -->
                                        <th>ภาพบัตร</th>
                                        <th>อนุมัติ</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $sql = "SELECT a.*, b.lavel_name 
                                        FROM personal AS a 
                                        LEFT JOIN lavel AS b ON a.lavel_id = b.lavel_id
                                        WHERE a.is_approved = 0";                                
                                        $result = mysqli_query($condb, $sql);
                                        $count = 1;
                                        while($rows = mysqli_fetch_array($result)) {
                                        ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $rows["personal_name"]; ?></td>
                                        <td><?php echo $rows["personal_username"]; ?></td>
                                        <td><?php echo $rows["personal_email"]; ?></td>
                                        <td><?php echo $rows["personal_password"]; ?></td>
                                        <td class="text-bold">
                                            <?php 
        $status = $rows['lavel_id'];
        if ($status == '1') {
            echo '<span style="color: blue;">ผู้ดูแลระบบ</span>';
        } elseif ($status == '2') {
            echo '<span style="color: blue;">คณาจารย์</span>';
        } elseif ($status == '3') {
            echo '<span style="color: blue;">นักศึกษา</span>';
        } elseif ($status == '4') {
            echo '<span style="color: blue;">บุคคลทั่วไป</span>';
        } elseif ($status == '5') {
            echo '<span style="color: brown;">ครู/อาจารย์</span>';
        }
        ?>
                                        </td>
                                        <!-- <td class="text-bold">
                                            <?php 
                                                if($rows["isActive"] == 1){
                                                echo '<span style="color: green;">Active</span>';
                                            }else{
                                                echo '<span style="color: red;">Not Active</span>';
                                            }
                                            ?>
                                        </td> -->
                                        <td>
                                            <a href="../image/card/<?php echo $rows["personal_imgcard"]; ?>" target="_black">
                                            <img src="../image/card/<?php echo $rows["personal_imgcard"]; ?>" class="img" style="width: 150px;">

                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-warning"
                                                href="approve_user.php?personal_id=<?php echo $rows["personal_id"]; ?>">
                                                <i class="fa fa-check"></i> อนุมัติ
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-danger"
                                                href="delete_user.php?personal_id=<?php echo $rows["personal_id"]; ?>"
                                                onclick="return confirm('คุณแน่ใจต้องการลบข้อมูลผู้รออนุมัติ?')">
                                                <i class="fa fa-trash">ลบการอนุมัติ</i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>



                                </tbody>

                                <!-- <tfoot>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>CSS grade</th>
                                    </tr>
                                </tfoot> -->

                            </table>

                        </div>
                        <!-- End of card-body. -->

                        <div class="card-footer">
                            Footer
                        </div>

                    </div>

                </div>
                <!-- End of col-12. -->

            </div>
            <!-- End of table row. -->

        </div>
        <!-- End of Container fluid. -->



    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Footer. -->
<?php include("footer.php"); ?>

<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {

    // alert("Hi");

    //Convert data to datatable.
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


});
</script>