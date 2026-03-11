<?php include("header.php"); ?>
<?php include("condb.php"); ?>
<?php include("left-menu.php") ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>เพิ่มข้อมูลภาพ Banner</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">ฟอร์มเพิ่มแบนเนอร์ใหม่</h3>
                        </div>
                        <form action="add_banner_db.php" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label for="banner_text">ข้อความอธิบายแบนเนอร์ (Text)</label>
                                    <input type="text" class="form-control" name="banner_text" id="banner_text" placeholder="กรอกข้อความที่ต้องการแสดง..." required>
                                </div>

                                <div class="form-group">
                                    <label for="image">อัปโหลดรูปภาพ</label>
                                    <input type="file" class="form-control-file" name="image" id="image" accept="image/*" required>
                                    <small class="text-danger">* รองรับไฟล์ .jpg, .jpeg, .png</small>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="manage_banner.php" class="btn btn-secondary">ยกเลิก</a>
                                <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>