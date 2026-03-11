<?php include("header.php"); ?>
<link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
<?php include("left-menu.php"); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>เพิ่มข้อมูลประวัติสาขา</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="manage_dekrmuti.php">จัดการข้อมูล</a></li>
                        <li class="breadcrumb-item active">เพิ่มข้อมูลใหม่</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-header" style="background:#001f3f linear-gradient(180deg,#26415c,#001f3f) repeat-x!important;">
                <h3 class="card-title">แบบฟอร์มเพิ่มข้อมูล</h3>
            </div>
            
            <form action="save_history.php" method="post" enctype="multipart/form-data" id="addHistoryForm">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label for="history_img"><i class="fa fa-image text-primary"></i> รูปภาพหน้าปก (แนะนำขนาด 800x600 px)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="history_img" name="history_img" accept="image/*" required onchange="previewImage(this)">
                            <label class="custom-file-label" for="history_img">เลือกไฟล์รูปภาพ...</label>
                        </div>
                        <div class="mt-2">
                            <img id="img_preview" src="../assets/images/no-image.jpg" class="img-thumbnail" style="max-width: 200px; display: none;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="history_link"><i class="fa fa-link text-info"></i> ลิงก์อ้างอิงภายนอก (ถ้ามี)</label>
                        <input type="url" class="form-control" id="history_link" name="history_link" placeholder="ตัวอย่าง: https://www.facebook.com/rmuti...">
                    </div>

                    <div class="form-group">
                        <label for="history_detail"><span class="text-danger">*</span> รายละเอียดประวัติ</label>
                        <textarea id="history_detail" name="history_detail" required></textarea>
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
                    <a href="manage_dekrmuti.php" class="btn btn-secondary">ยกเลิก</a>
                </div>
            </form>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>

<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(function () {
        // เปิดใช้งาน Summernote
        $('#history_detail').summernote({
            height: 300,
            placeholder: 'พิมพ์รายละเอียดที่นี่...'
        });

        // แสดงชื่อไฟล์ที่เลือกใน Custom File Input
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });

    // ฟังก์ชัน Preview รูปภาพก่อนอัปโหลด
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result).fadeIn();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>