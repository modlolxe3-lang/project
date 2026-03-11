<?php

include("condb.php");

$id = $_POST["id"];
$image = $_FILES["image"]["name"];

// โฟลเดอร์ที่ต้องการจะเก็บรูปภาพ
$target_directory = "../image/banner/";

// ย้ายไฟล์รูปภาพไปยังโฟลเดอร์ที่ต้องการ
if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_directory . $image)) {
    // ทำงานหลังจากอัพโหลดไฟล์สำเร็จ
    // อัพเดทข้อมูลในฐานข้อมูล
    $sql = "UPDATE tbl_banner
            SET image = '$image'
            WHERE id = '$id'";
                            
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
