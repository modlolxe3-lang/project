<?php
include("condb.php"); // ตรวจสอบว่าไฟล์นี้อยู่ในโฟลเดอร์ admin

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. รับค่าจากฟอร์ม
    $id = mysqli_real_escape_string($condb, $_POST['id']);
    $curriculum_name = mysqli_real_escape_string($condb, $_POST['curriculum_name']);
    $curriculum_detail = mysqli_real_escape_string($condb, $_POST['curriculum_detail']);
    $curriculum_duration = mysqli_real_escape_string($condb, $_POST['curriculum_duration']);
    $curriculum_career = mysqli_real_escape_string($condb, $_POST['curriculum_career']);
    $curlavel_id = mysqli_real_escape_string($condb, $_POST['curlavel_id']);
    
    // ดึงชื่อไฟล์เดิมจาก Hidden Input
    $curriculum_file = $_POST['old_curriculum_file'];
    $curriculum_img = ""; // สำหรับจัดการรูปภาพ (ถ้ามี)

    // 2. จัดการไฟล์ PDF
    if (isset($_FILES['curriculum_file']) && $_FILES['curriculum_file']['error'] == 0) {
        $file_name = $_FILES['curriculum_file']['name'];
        $file_tmp = $_FILES['curriculum_file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // ตรวจสอบนามสกุลไฟล์อีกครั้งเพื่อความปลอดภัย
        if ($file_ext === "pdf") {
            // ตั้งชื่อไฟล์ใหม่: cur_วันที่_เวลา_สุ่มเลข.pdf
            $new_file_name = "cur_" . date('Ymd_His') . "_" . rand(100, 999) . ".pdf";
            
            // Path: ถอยออกไป 1 ชั้นแล้วเข้าโฟลเดอร์ uploads (ตามรูปโครงสร้างไฟล์)
            $upload_path = "../uploads/" . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // ลบไฟล์เก่าทิ้งถ้ามีการอัปโหลดไฟล์ใหม่สำเร็จ
                if (!empty($_POST['old_curriculum_file'])) {
                    @unlink("../uploads/" . $_POST['old_curriculum_file']);
                }
                $curriculum_file = $new_file_name;
            }
        }
    }

    // 3. จัดการรูปภาพ (ถ้ามีการเปลี่ยนรูป)
    // โค้ดส่วนนี้เสริมให้กรณีคุณต้องการอัปเดตรูปภาพด้วย
    if (isset($_FILES['curriculum_img']) && $_FILES['curriculum_img']['error'] == 0) {
        $img_name = $_FILES['curriculum_img']['name'];
        $img_tmp = $_FILES['curriculum_img']['tmp_name'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $new_img_name = "img_" . date('Ymd_His') . "_" . rand(100, 999) . "." . $img_ext;
        
        if (move_uploaded_file($img_tmp, "../image/curriculum/" . $new_img_name)) {
            // อัปเดต SQL ให้เปลี่ยนรูปภาพด้วย
            $sql_img = ", curriculum_img = '$new_img_name'";
        }
    } else {
        $sql_img = "";
    }

    // 4. อัปเดตข้อมูลลงฐานข้อมูล
    $sql = "UPDATE curriculum SET 
            curriculum_name = '$curriculum_name',
            curriculum_detail = '$curriculum_detail',
            curriculum_duration = '$curriculum_duration',
            curriculum_career = '$curriculum_career',
            curlavel_id = '$curlavel_id',
            curriculum_file = '$curriculum_file'
            $sql_img
            WHERE curriculum_id = '$id'";

    $result = mysqli_query($condb, $sql);

    // 5. ส่งกลับไปยังหน้าจัดการ พร้อม Alert (เพราะหน้าฟอร์มมี SweetAlert รอรับอยู่แล้ว)
    if ($result) {
        echo "<script>window.location='manage_curriculum.php';</script>";
    } else {
        echo "Error: " . mysqli_error($condb);
    }
}
?>