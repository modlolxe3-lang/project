<?php include("header.php"); ?>
<link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
<?php include("left-menu.php"); ?>

<?php include("condb.php"); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>เพิ่มข้อมูลหลักสูตร</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="main.php">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="manage_curriculum.php">จัดการข้อมูลหลักสูตร</a></li>
                        <li class="breadcrumb-item active">เพิ่มข้อมูลหลักสูตร</li>
                    </ol>
                </div>
            </div>
        </div></section>

    <section class="content">

        <div class="card">
            <div class="card card-primary">
                <div class="card-header "
                    style="background:#001f3f linear-gradient(180deg,#26415c,#001f3f) repeat-x!important ;">
                    <h3 class="card-title">เพิ่มข้อมูลหลักสูตร</h3>
                </div>
                <form method="post" action="add_curriculum.php" enctype="multipart/form-data">
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="curriculum_name "><span class="text-danger">*</span> ชื่อหลักสูตร</label>
                            <input type="text" class="form-control" id="curriculum_name" name="curriculum_name"
                            placeholder="กรุณาใส่ชื่อหลักสูตร" required>
                        </div>

                        <div class="form-group">
                            <label for="curriculum_img"><span class="text-danger">*</span> รูปภาพหน้าปก </label>
                            <input type="file" class="form-control" id="curriculum_img" name="curriculum_img"
                             accept="image/*" required>
                        </div>

                        <div class="form-group">
                            <label for="curriculum_detail"><span class="text-danger">*</span> รายละเอียดหลักสูตร </label>
                            <textarea class="form-control" id="curriculum_detail" name="curriculum_detail"
                            placeholder="กรุณารายละเอียด"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="curriculum_duration"><span class="text-danger">*</span> <i
                                    class="fa fa-clock text-info"></i> ระยะเวลาการศึกษา</label>
                            <input type="text" class="form-control" id="curriculum_duration" name="curriculum_duration"
                                placeholder="ตัวอย่าง: 4 ปี (หรือเทียบโอน 2 ปีต่อเนื่อง)" required>
                        </div>

                        <div class="form-group">
                            <label for="curriculum_career"><span class="text-danger">*</span> <i
                                    class="fa fa-briefcase text-primary"></i> สายงานอาชีพที่รองรับ</label>
                            <textarea class="form-control" id="curriculum_career" name="curriculum_career" rows="3"
                                placeholder="ตัวอย่าง: นักวิชาการคอมพิวเตอร์, โปรแกรมเมอร์, นักวิเคราะห์ระบบ"
                                required></textarea>
                            <small class="text-muted">* กด Enter เพื่อขึ้นบรรทัดใหม่สำหรับแต่ละอาชีพ</small>
                        </div>

                        <div class="form-group">
                            <label for="curlavel_id"><span class="text-danger">*</span> ระดับของหลักสูตร</label>
                            <select class="form-control custom-select" id="curlavel_id" name="curlavel_id" required>
                                <option value="">กรุณาเลือก</option>
                                <option value="1">หลักสูตรประกาศนียบัตรวิชาชีพชั้นสูง</option>
                                <option value="2">หลักสูตรปริญญาตรี</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="curriculum_file"><i class="fa-solid fa-file-pdf text-danger"></i> อัปโหลดเอกสารโครงสร้างหลักสูตร (PDF, DOCX)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="curriculum_file" name="curriculum_file"
                                    accept=".pdf,.doc,.docx">
                                <label class="custom-file-label" for="curriculum_file">เลือกไฟล์เอกสาร...</label>
                            </div>
                            <small class="text-muted">* หากยังไม่มีไฟล์ สามารถข้ามไปก่อนได้</small>
                        </div>

                    </div>
                    
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-md btn-success" style="background: #0b7d79!important"><i
                                class="fa fa-save"></i> บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>
            </section>
    </div>
<?php include("footer.php"); ?>
<script src="../plugins/summernote/summernote-bs4.min.js"></script>

<script>
$(function() {
    // Summernote
    $('#curriculum_detail').summernote()
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

    // สคริปต์ทำให้ชื่อไฟล์ปรากฏในช่องอัปโหลดเมื่อเลือกไฟล์เสร็จ
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
});
</script>