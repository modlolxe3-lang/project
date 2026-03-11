<!-- Header. -->
<?php include("header.php"); ?>
<!-- Left Menu. -->
<?php include("left-menu.php"); ?>

<?php include("condb.php"); ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>เพิ่มข้อมูลผู้ใช้งาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="main.php">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="manage_users.php">จัดการข้อมูลผู้ใช้งาน</a></li>
                        <li class="breadcrumb-item active">เพิ่มข้อมูลผู้ใช้งาน</li>
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
                    <h3 class="card-title">เพิ่มข้อมูล</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="add_user.php" enctype="multipart/form-data">
                    <!-- <input type="text" name="personal_id" value="personal_id"> -->

                    <div class="card-body">
                        <div class="form-group">
                            <label for="personal_name"><span class="text-danger">*</span> ชื่อ - นามสกุล</label>
                            <input type="varchar" class="form-control" id="personal_name" name="personal_name"
                                placeholder="(หากเป็นอาจารย์กรุณากรอกตำแหน่งทางวิชาการด้วย)" require>
                        </div>
                        <div class="form-group">
                            <label for="personal_username"><span class="text-danger">*</span> ชื่อผู้ใช้งาน</label>
                            <input type="varchar" class="form-control" id="personal_username" name="personal_username"
                                placeholder="(ชื่อผู้ใช้งาน Internet ของมหาวิทยาลัย เช่น ชญานนท์ ภาคฐิน ชื่อผู้ใช้คือ Chayanon.Ph)"
                                require>
                        </div>
                        <div class="form-group">
                            <label for="personal_password"><span class="text-danger">*</span> รหัสผ่าน </label>
                            <input type="varchar" class="form-control" id="personal_password" name="personal_password"
                                placeholder="(กำหนดรหัสผ่านอย่างน้อย 8 ตัวอักษร)">
                        </div>
                        <div class="form-group">
                            <label for="personal_tel"><span class="text-danger">*</span> เบอร์โทรศัพท์ </label>
                            <input type="varchar" class="form-control" id="personal_tel" name="personal_tel"
                                placeholder="เบอร์โทรศัพท์ของท่าน">
                        </div>
                        <div class="from-group">
                            <label for="lavel_id"><span class="text-danger">*</span> ประเภทผู้ใช้งาน</label>
                            <select class="from-control form-control custom-select" id="lavel_id" name="lavel_id"
                                required>
                                <option value="">กรุณาเลือก</option>
                                <option value="1">ผู้ดูแลระบบ</option>
                                <option value="2">อาจารย์</option>
                                <option value="3">นักศึกษา</option>
                            </select>
                        </div>

                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
$(document).ready(function(){
    // เมื่อฟอร์มถูกส่ง
    $('form').submit(function(event){
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
});

</script>