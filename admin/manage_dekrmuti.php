<?php include("header.php"); ?>

<?php include("condb.php"); ?>

<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<?php include("left-menu.php"); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>จัดการข้อมูลประวัติสาขา (เด็ก RMUTI)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="main.php">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">จัดการข้อมูลประวัติสาขา</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"
                            style="background:#001f3f linear-gradient(180deg,#26415c,#001f3f) repeat-x!important;">
                            <h3 class="card-title" style="color: #ffffff;">รายการข้อมูลประวัติสาขา</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <a class="btn btn-success" href="frm_add_history.php">
                                    <i class="fa fa-plus-square"></i> เพิ่มข้อมูลประวัติ
                                </a>
                            </div>

                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th width="15%" class="text-center">รูปปก</th>
                                        <th width="40%">รายละเอียดประวัติ</th>
                                        <th width="20%" class="text-center">ลิงก์อ้างอิง</th>
                                        <th width="20%" class="text-center">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tbl_history ORDER BY id DESC";
                                    $result = mysqli_query($condb, $sql);
                                    $count = 1;
                                    if ($result) {
                                        while ($rows = mysqli_fetch_array($result)) {
                                            // แก้ไขตรงนี้: ใช้ ?? "" เพื่อป้องกัน Undefined array key
                                            $img_name = $rows['history_img'] ?? "";
                                            $history_link = $rows['history_link'] ?? "";

                                            $img_path = (!empty($img_name) && file_exists("../image/history/" . $img_name))
                                                ? "../image/history/" . $img_name
                                                : "../assets/images/no-image.jpg";
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $count++; ?></td>
                                                <td class="text-center">
                                                    <a href="<?php echo $img_path; ?>" target="_blank">
                                                        <img src="<?php echo $img_path; ?>" class="img-thumbnail"
                                                            style="width: 80px; height: 60px; object-fit: cover;">
                                                    </a>
                                                </td>
                                                <td>
                                                    <div style="font-size: 0.9rem;">
                                                        <?php echo mb_strimwidth(strip_tags($rows["history_detail"] ?? ""), 0, 150, "..."); ?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (!empty($history_link)) { ?>
                                                        <a href="<?php echo $history_link; ?>" target="_blank"
                                                            class="btn btn-xs btn-outline-primary rounded-pill">
                                                            <i class="fa fa-external-link-alt"></i> เปิดลิงก์
                                                        </a>
                                                    <?php } else {
                                                        echo "-";
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm btn-warning"
                                                            href="frm_edit_history.php?id=<?php echo $rows["id"]; ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a class="btn btn-sm btn-danger"
                                                            href="delete_history.php?id=<?php echo $rows["id"]; ?>"
                                                            onclick="return confirm('คุณแน่ใจว่าต้องการลบข้อมูลนี้?')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-muted">
                            ระบบจัดการข้อมูลประวัติสาขา RMUTI
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>

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
    $(document).ready(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json" // เพิ่มภาษาไทย
            },
            "buttons": ["copy", "csv", "excel", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>