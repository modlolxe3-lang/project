<?php
include("condb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $banner_text = mysqli_real_escape_string($condb, $_POST['banner_text']);
    
    // ตั้งชื่อไฟล์ภาพใหม่กันชื่อซ้ำ
    $date1 = date("Ymd_His");
    $numrand = (mt_rand());
    $image = (isset($_POST['image']) ? $_POST['image'] : '');
    $upload = $_FILES['image']['name'];

    if ($upload != '') {
        $path = "../image/banner/"; // Path ที่เก็บรูปภาพ
        $type = strrchr($_FILES['image']['name'], ".");
        $newname = "banner_" . $date1 . $numrand . $type;
        $path_copy = $path . $newname;

        // คัดลอกไฟล์ไปยังโฟลเดอร์
        move_uploaded_file($_FILES['image']['tmp_name'], $path_copy);

        // บันทึกข้อมูลลงฐานข้อมูล (รวมข้อความด้วย)
        $sql = "INSERT INTO tbl_banner (image, banner_text) VALUES ('$newname', '$banner_text')";
        $result = mysqli_query($condb, $sql);

        if ($result) {
            echo "<script>";
            echo "alert('เพิ่มข้อมูลสำเร็จ');";
            echo "window.location = 'manage_banner.php';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');";
            echo "window.history.back();";
            echo "</script>";
        }
    }
}
?>