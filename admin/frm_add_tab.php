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
                    <h1>เพิ่มข้อมูลส่วนแถบน้ำเงิน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="main.php">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="manage_tab.php">จัดการข้อมูลแถบน้ำเงิน</a></li>
                        <li class="breadcrumb-item active">เพิ่มข้อมูล</li>
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
                <form method="post" action="add_tab.php" enctype="multipart/form-data">
                    <!-- <input type="text" name="teacher_id" value="teacher_id"> -->

                    <div class="card-body">
                        <div class="form-group">
                            <label for="teacher_name"><span class="text-danger">*</span> ชื่อ - นามสกุล (หัวหน้าสาขาวิชาระบบสารสนเทศ)</label>
                            <input type="varchar" class="form-control" id="teacher_name" name="teacher_name"
                                placeholder="(กรุณากรอกชื่อหัวหน้าสาขาวิชาระบบสารสนเทศ)" require>
                        </div>
                        <div class="form-group">
                            <label for="image_name"><span class="text-danger">*</span> รูปภาพ </label>
                            <div class="img">
                            </div>
                            <input type="file" class="form-control" id="image_name" name="image_name"
                                placeholder="รูปภาพอาจารย์" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="description"><span class="text-danger">*</span> รายละเอียดข้อความ </label>
                            <textarea class="form-control" id="description" name="description"
                                placeholder="กรุณารายละเอียด"> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="youtube_link"><span class="text-danger">*</span> Link Youtube</label>
                            <input type="varchar" class="form-control" id="youtube_link" name="youtube_link"
                                placeholder="(กรุณาใส่ Link Youtube)" require>
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