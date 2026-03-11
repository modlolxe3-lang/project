<?php

include("condb.php");

// โฟลเดอร์ที่ต้องการจะเก็บรูปภาพ
$target_directory = "../image/banner/";

// รับข้อมูลจากฟอร์ม
$image = $_FILES['image']['name'];

// ย้ายไฟล์รูปภาพไปยังโฟลเดอร์ที่ต้องการ
if (move_uploaded_file($_FILES['image']['tmp_name'], $target_directory . $image)) {
    // ทำงานหลังจากอัพโหลดไฟล์สำเร็จ
    // บันทึกรูปภาพลงในฐานข้อมูล
    $sql = "INSERT INTO tbl_banner (image) VALUES ('$image')";
                            
    $result = mysqli_query($condb, $sql);

    if ($result) {
        // หากบันทึกข้อมูลสำเร็จ
        header("Location: manage_banner.php");
    } else {
        // หากมีปัญหาในการบันทึกข้อมูล
        echo "ไม่สามารถบันทึกข้อมูลได้...";
    }
} else {
    // หากมีปัญหาในการอัพโหลดไฟล์รูปภาพ
    echo "เกิดข้อผิดพลาดในการอัพโหลดไฟล์...";
}

?>
