<?php include("header.php"); ?>
<?php include("condb.php"); ?>
<?php include("left-menu.php") ?>

<?php
// ดึงข้อมูลเดิมมาแสดง
$id = $_GET['id'];
$sql = "SELECT * FROM tbl_banner WHERE id = '$id'";
$result = mysqli_query($condb, $sql);
$row = mysqli_fetch_array($result);
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>แก้ไขข้อมูลภาพ Banner</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">ฟอร์มแก้ไขแบนเนอร์</h3>
                        </div>
                        
                        <form action="edit_banner_db.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">

                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label for="banner_text">ข้อความอธิบายแบนเนอร์ (Text)</label>
                                    <input type="text" class="form-control" name="banner_text" id="banner_text" value="<?php echo htmlspecialchars($row['banner_text'] ?? ''); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>รูปภาพเดิม</label><br>
                                    <img src="../image/banner/<?php echo $row['image']; ?>" width="300px" style="border-radius: 8px;">
                                </div>

                                <div class="form-group">
                                    <label for="image">อัปโหลดรูปภาพใหม่ <small class="text-primary">(หากไม่ต้องการเปลี่ยนรูป ให้เว้นว่างไว้)</small></label>
                                    <input type="file" class="form-control-file" name="image" id="image" accept="image/*">
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="manage_banner.php" class="btn btn-secondary">ยกเลิก</a>
                                <button type="submit" class="btn btn-warning">บันทึกการแก้ไข</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>