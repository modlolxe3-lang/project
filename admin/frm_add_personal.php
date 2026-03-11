<!-- Header. -->
<?php include("header.php"); ?>
<!-- summernote -->
<link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
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
                    <h1>เพิ่มข้อมูลบุคลากร</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="main.php">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="manage_personal.php">จัดการข้อมูลบุคลากร</a></li>
                        <li class="breadcrumb-item active">เพิ่มข้อมูลบุคลากร</li>
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
                    <h3 class="card-title">เพิ่มข้อมูลบุคลากร</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="add_personal.php" enctype="multipart/from-data">
                <!-- <input type="text" name="personal_id" value="personal_id"> -->
                    

                    <div class="card-body">
                        <div class="form-group">
                            <label for="personal_name"><span class="text-danger">*</span> ชื่ออาจารย์</label>
                            <input type="varchar" class="form-control" id="personal_name" name="personal_name"
                            placeholder="กรุณาใส่ชื่อจริง" require>
                        </div>
                        <div class="form-group">
                            <label for="personal_name"><span class="text-danger">*</span> ตำแหน่ง</label>
                            <input type="varchar" class="form-control" id="personal_position" name="personal_position"
                            placeholder="กรุณาใส่ตำแหน่ง" require>
                        </div>
                        <div class="form-group">
                            <label for="personal_img"><span class="text-danger">*</span> รูปภาพ </label>
                            <div class="img">
                            </div>
                            <input type="file" class="form-control" id="personal_img" name="personal_img"
                             placeholder="รูปภาพอาจารย์" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="bachelor_degree"><span class="text-danger">*</span> ปริญญาตรี</label>
                            <input type="varchar" class="form-control" id="bachelor_degree" name="bachelor_degree"
                               placeholder="กรุณาระดับการศึกษาปริญญาตรี" require>
                        </div>
                        <div class="form-group">
                            <label for="master_degree"><span class="text-danger">*</span> ปริญญาโท</label>
                            <input type="varchar" class="form-control" id="master_degree" name="master_degree"
                               placeholder="กรุณาระดับการศึกษาปริญญาโท" require>
                        </div>
                        <div class="form-group">
                            <label for="doctorate_degree"><span class="text-danger">*</span> ปริญญาเอก</label>
                            <input type="varchar" class="form-control" id="doctorate_degree" name="doctorate_degree"
                                placeholder="กรุณาระดับการศึกษาปริญญาเอก" require>
                        </div>
                        <div class="form-group">
                            <label for="personal_performace"><span class="text-danger">*</span> ผลงาน </label>
                            <textarea class="form-control" id="personal_performace" name="personal_performace"
                            placeholder="ผลงาน"> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="personal_email"><span class="text-danger">*</span> อีเมลล์</label>
                            <input type="varchar" class="form-control" id="personal_email" name="personal_email"
                            placeholder="กรุณาใส่อีเมลล์" require>
                        </div>
                        <div class="form-group">
                            <label for="personal_tel"><span class="text-danger">*</span> เบอร์โทร</label>
                            <input type="varchar" class="form-control" id="personal_tel" name="personal_tel"
                            placeholder="กรุณาใส่เบอร์โทร" require>
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
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>

<script>
$(function() {
    // Summernote
    $('#personal_performace').summernote()

    
})
</script>
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