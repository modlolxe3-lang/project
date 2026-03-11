<!-- Header. -->
<?php include("header.php"); ?>
<!-- summernote -->
<link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
<!-- Left Menu. -->
<?php include("left-menu.php"); ?>

<?php include("condb.php"); ?>

<?php

$curriculum_id = $_GET["curriculum_id"];
$sql = "SELECT* FROM curriculum WHERE curriculum_id = '$curriculum_id' ";
$result = mysqli_query($condb, $sql);
$row = mysqli_fetch_array($result);



?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>แก้ไขข้อมูลหลักสูตร</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="main.php">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="manage_curriculum.php">จัดการข้อมูลหลักสูตร</a></li>
                        <li class="breadcrumb-item active">เพิ่มข้อมูลหลักสูตร</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <!-- Default box -->
            <div class="card card-primary">
                <div class="card-header "
                    style="background:#001f3f linear-gradient(180deg,#26415c,#001f3f) repeat-x!important ;">
                    <h3 class="card-title">แก้ไขข้อมูลหลักสูตร</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="edit_curriculum.php" enctype="multipart/form-data">
                    <input type="text" id="id" name="id" value="<?php echo $row["curriculum_id"]; ?>" hidden>


                    <div class="card-body">
                        <div class="form-group">
                            <label for="curriculum_name"><span class="text-danger">*</span> ชื่อหลักสูตร</label>
                            <input type="text" class="form-control" id="curriculum_name" name="curriculum_name"
                                value="<?php echo $row["curriculum_name"]; ?>" placeholder="กรุณาใส่ชื่อหลักสูตร"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="curriculum_img">รูปภาพปัจจุบัน</label>
                            <div class="img mb-2">
                                <img src="../image/curriculum/<?php echo $row["curriculum_img"]; ?>"
                                    class="img-thumbnail" style="width: 150px;">
                            </div>
                            <input type="file" class="form-control" id="curriculum_img" name="curriculum_img"
                                accept="image/*">
                            <small class="text-muted">* หากไม่ต้องการเปลี่ยนรูปภาพ ไม่ต้องเลือกไฟล์ใหม่</small>
                        </div>

                        <div class="form-group">
                            <label for="curriculum_detail"><span class="text-danger">*</span> รายละเอียดหลักสูตร
                            </label>
                            <textarea class="form-control" id="curriculum_detail" name="curriculum_detail"
                                placeholder="กรุณารายละเอียด"><?php echo $row["curriculum_detail"]; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="curriculum_duration"><span class="text-danger">*</span> <i
                                    class="fa fa-clock text-info"></i> ระยะเวลาการศึกษา</label>
                            <input type="text" class="form-control" id="curriculum_duration" name="curriculum_duration"
                                value="<?php echo $row["curriculum_duration"]; ?>"
                                placeholder="ตัวอย่าง: 4 ปี (หรือเทียบโอน 2 ปีต่อเนื่อง)" required>
                        </div>



                        <div class="form-group">
                            <label for="curriculum_career"><span class="text-danger">*</span> <i
                                    class="fa fa-briefcase text-primary"></i> สายงานอาชีพที่รองรับ</label>
                            <textarea class="form-control" id="curriculum_career" name="curriculum_career" rows="3"
                                placeholder="ตัวอย่าง: นักวิชาการคอมพิวเตอร์, โปรแกรมเมอร์, นักวิเคราะห์ระบบ"
                                required><?php echo $row["curriculum_career"]; ?></textarea>
                            <small class="text-muted">* แนะนำให้คั่นด้วยเครื่องหมายจุลภาค ( , )</small>
                        </div>

                        <div class="form-group">
                            <label for="curlavel_id"><span class="text-danger">*</span> ระดับของหลักสูตร</label>
                            <select class="form-control custom-select" id="curlavel_id" name="curlavel_id" required>
                                <option value="">กรุณาเลือก</option>
                                <option value="1" <?php if ($row['curlavel_id'] == "1")
                                    echo 'selected'; ?>>
                                    หลักสูตรประกาศนียบัตรวิชาชีพชั้นสูง</option>
                                <option value="2" <?php if ($row['curlavel_id'] == "2")
                                    echo 'selected'; ?>>
                                    หลักสูตรปริญญาตรี</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="curriculum_file">
                            <i class="fa-solid fa-file-pdf text-danger"></i> อัปโหลด/แก้ไข เอกสารโครงสร้างหลักสูตร
                            (เฉพาะ PDF เท่านั้น)
                        </label>

                        <?php if (!empty($row["curriculum_file"])) { ?>
                            <div class="mb-2">
                                <span>ไฟล์ปัจจุบัน: </span>
                                <a href="uploads/<?php echo $row["curriculum_file"]; ?>" target="_blank"
                                    class="btn btn-sm btn-outline-info rounded-pill">
                                    <i class="fa-solid fa-eye"></i> ดูไฟล์เดิม (<?php echo $row["curriculum_file"]; ?>)
                                </a>
                            </div>
                        <?php } ?>

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="curriculum_file" name="curriculum_file"
                                accept=".pdf" onchange="checkFileType(this)">
                            <label class="custom-file-label" for="curriculum_file">เลือกไฟล์ PDF ใหม่...</label>
                        </div>
                        <small class="text-danger">* อนุญาตเฉพาะไฟล์นามสกุล .pdf เท่านั้น</small>

                        <input type="hidden" name="old_curriculum_file"
                            value="<?php echo $row["curriculum_file"] ?? ''; ?>">
                    </div>

                    <script>
                        // ฟังก์ชันช่วยเช็คหน้าเครื่องผู้ใช้
                        function checkFileType(input) {
                            const filePath = input.value;
                            const allowedExtensions = /(\.pdf)$/i;
                            if (!allowedExtensions.exec(filePath)) {
                                alert('กรุณาเลือกไฟล์ที่มีนามสกุล .pdf เท่านั้น');
                                input.value = '';
                                return false;
                            }
                        }
                    </script>

                    <!-- /.card-body -->

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-md btn-success" style="background: #0b7d79!important"><i
                                class="fa fa-save"></i> บันทึกข้อมูล</button>
                    </div>
                </form>
                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Footer. -->
<?php include("footer.php"); ?>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>

<script>
    $(function () {
        // Summernote
        $('#curriculum_detail').summernote()


    })
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        // เมื่อฟอร์มถูกส่ง
        $('form').submit(function (event) {
            // หยุดการกระทำปกติของฟอร์ม
            event.preventDefault();
            // แสดง Sweet Alert
            Swal.fire({
                title: 'บันทึกข้อมูลสำเร็จ!',
                text: 'ข้อมูลของคุณได้ถูกบันทึกเรียบร้อยแล้ว',
                icon: 'success',
                confirmButtonText: 'ตกลง'
            }).then((result) => {
                // หลังจากที่ผู้ใช้กดปุ่มตกลง
                if (result.isConfirmed) {
                    // ส่งข้อมูลฟอร์มไปยังหน้าที่ต้องการ
                    $('form').unbind('submit').submit();
                }
            });
        });

        // สคริปต์ทำให้ชื่อไฟล์ปรากฏในช่องอัปโหลดเมื่อเลือกไฟล์เสร็จ
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>
</script>