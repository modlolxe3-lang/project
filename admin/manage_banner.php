<?php include("header.php"); ?>
<?php include("condb.php"); ?>

<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<style>
    /* ปรับแต่งส่วนแสดงแบนเนอร์และข้อความทับภาพ */
    .banner-preview {
        position: relative;
        display: inline-block;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        max-width: 100%;
        background-color: #f8f9fa;
    }
    .banner-preview img {
        display: block;
        max-width: 400px;
        width: 100%;
        height: auto;
        transition: transform 0.3s;
    }
    .banner-preview:hover img {
        transform: scale(1.02);
    }
    .banner-text-overlay {
        position: absolute;
        bottom: 10%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        white-space: nowrap;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
        pointer-events: none; /* ไม่ให้รบกวนการคลิกรูป */
    }
    .btn-pink { background-color: #ff69b4; color: white; border: none; }
    .btn-pink:hover { background-color: #ff85c2; color: white; }
    .table-valign-middle td { vertical-align: middle !important; }
</style>

<?php include("left-menu.php") ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-images text-primary"></i> จัดการข้อมูลภาพ Banner</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">จัดการ Banner</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header" style="background:#001f3f linear-gradient(180deg,#26415c,#001f3f) repeat-x!important;">
                            <h3 class="card-title" style="color: #ffffff;"><i class="fas fa-list"></i> รายการแบนเนอร์หน้าแรก</h3>
                        </div>

                        <div class="card-body">
                            <a class="btn btn-md btn-success mb-4 shadow-sm" href="frm_add_banner.php" style="border-radius: 20px; padding: 8px 20px;">
                                <i class="fa fa-plus-circle"></i> เพิ่มแบนเนอร์ใหม่
                            </a>
                            
                            <table id="example1" class="table table-bordered table-hover table-valign-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="40%" class="text-center">รูปภาพแบนเนอร์ (Preview)</th>
                                        <th width="40%">รายละเอียด (ข้อความ & ลิงก์)</th> 
                                        <th width="20%" class="text-center">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sql = "SELECT * FROM tbl_banner ORDER BY id DESC";
                                        $result = mysqli_query($condb, $sql);
                                        while($rows = mysqli_fetch_array($result)){
                                            $has_text = !empty($rows["banner_text"]);
                                            // เช็คว่ามีคอลัมน์ banner_link ไหม และมีข้อมูลหรือไม่
                                            $has_link = isset($rows["banner_link"]) && !empty($rows["banner_link"]); 
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <div class="banner-preview">
                                                <a href="../image/banner/<?php echo htmlspecialchars($rows["image"]); ?>" data-toggle="lightbox" data-title="<?php echo htmlspecialchars($rows["banner_text"]); ?>">
                                                    <img src="../image/banner/<?php echo htmlspecialchars($rows["image"]); ?>" alt="Banner Image">
                                                </a>
                                                <?php if($has_text) { ?>
                                                    <div class="banner-text-overlay">
                                                        <?php echo htmlspecialchars($rows["banner_text"]); ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="mb-2">
                                                <strong>ข้อความในภาพ:</strong><br>
                                                <?php 
                                                    echo $has_text ? '<span class="text-primary"><i class="fas fa-quote-left text-muted text-xs mr-1"></i> ' . htmlspecialchars($rows["banner_text"]) . ' <i class="fas fa-quote-right text-muted text-xs ml-1"></i></span>' : '<span class="text-muted"><i class="fas fa-minus"></i> ไม่มีข้อความ</span>'; 
                                                ?>
                                            </div>
                                            <div>
                                                <strong>ลิงก์ปลายทาง (URL):</strong><br>
                                                <?php if($has_link) { ?>
                                                    <a href="<?php echo htmlspecialchars($rows["banner_link"]); ?>" target="_blank" class="btn btn-xs btn-outline-info mt-1">
                                                        <i class="fas fa-external-link-alt"></i> ทดสอบลิงก์
                                                    </a>
                                                    <small class="text-muted ml-1"><?php echo htmlspecialchars($rows["banner_link"]); ?></small>
                                                <?php } else { ?>
                                                    <span class="badge badge-light text-muted"><i class="fas fa-unlink"></i> ไม่ได้กำหนดลิงก์</span>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-warning shadow-sm" href="frm_edit_banner.php?id=<?php echo $rows["id"]; ?>" title="แก้ไขข้อมูลและลิงก์">
                                                <i class="fa fa-edit"></i> แก้ไข
                                            </a>
                                            <a class="btn btn-sm btn-danger shadow-sm" href="delete_banner.php?id=<?php echo $rows["id"]; ?>" onclick="return confirm('คุณแน่ใจต้องการลบข้อมูลแบนเนอร์นี้ ?')" title="ลบแบนเนอร์">
                                                <i class="fa fa-trash"></i> ลบ
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-muted text-sm">
                            <i class="fas fa-info-circle"></i> เคล็ดลับ: คุณสามารถแก้ไขเพื่อเพิ่มข้อความทับลงบนรูปภาพ และตั้งค่าให้เมื่อคลิกรูปภาพแล้วลิงก์ไปยังเว็บไซต์อื่นได้
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
$(document).ready(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false, // ปิดการเรียงลำดับอัตโนมัติเพื่อให้แบนเนอร์ใหม่สุดอยู่บนตามคำสั่ง SQL
        "language": {
            "search": "ค้นหา:",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            }
        },
        "buttons": [
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-light' },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success' },
            { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info' }
        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});
</script>