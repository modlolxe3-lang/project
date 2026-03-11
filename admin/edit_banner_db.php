<?php
include("condb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($condb, $_POST['id']);
    $banner_text = mysqli_real_escape_string($condb, $_POST['banner_text']);
    $old_image = $_POST['old_image'];
    $upload = $_FILES['image']['name'];

    // เช็คว่ามีการอัปโหลดรูปภาพใหม่มาหรือไม่
    if ($upload != '') {
        $date1 = date("Ymd_His");
        $numrand = (mt_rand());
        $path = "../image/banner/";
        $type = strrchr($_FILES['image']['name'], ".");
        $newname = "banner_" . $date1 . $numrand . $type;
        $path_copy = $path . $newname;

        // อัปโหลดไฟล์ใหม่
        move_uploaded_file($_FILES['image']['tmp_name'], $path_copy);

        // ลบไฟล์รูปเก่าออกจากโฟลเดอร์ (ถ้าต้องการลบ)
        if (file_exists($path . $old_image)) {
            unlink($path . $old_image);
        }

        // อัปเดตข้อมูลแบบมีรูปภาพใหม่
        $sql = "UPDATE tbl_banner SET image='$newname', banner_text='$banner_text' WHERE id='$id'";
    } else {
        // อัปเดตข้อมูลเฉพาะข้อความ (ใช้รูปภาพเดิม)
        $sql = "UPDATE tbl_banner SET banner_text='$banner_text' WHERE id='$id'";
    }

    $result = mysqli_query($condb, $sql);

    if ($result) {
        echo "<script>";
        echo "alert('แก้ไขข้อมูลสำเร็จ');";
        echo "window.location = 'manage_banner.php';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('เกิดข้อผิดพลาดในการแก้ไขข้อมูล');";
        echo "window.history.back();";
        echo "</script>";
    }
}
?>