<?php
// เชื่อมต่อฐานข้อมูล
include("condb.php");

// ตรวจสอบว่ามีการส่งข้อมูลแบบ POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. รับค่าจากฟอร์มและป้องกัน SQL Injection เบื้องต้น
    $curriculum_name = mysqli_real_escape_string($condb, $_POST['curriculum_name']);
    $curriculum_detail = mysqli_real_escape_string($condb, $_POST['curriculum_detail']);
    $curriculum_duration = mysqli_real_escape_string($condb, $_POST['curriculum_duration']);
    $curriculum_career = mysqli_real_escape_string($condb, $_POST['curriculum_career']);
    $curlavel_id = mysqli_real_escape_string($condb, $_POST['curlavel_id']);

    // 2. จัดการอัปโหลดรูปภาพ (curriculum_img)
    $new_img_name = "";
    if (isset($_FILES['curriculum_img']) && $_FILES['curriculum_img']['error'] == 0) {
        $img_ext = pathinfo($_FILES['curriculum_img']['name'], PATHINFO_EXTENSION);
        // สุ่มชื่อไฟล์ใหม่เพื่อป้องกันชื่อซ้ำ
        $new_img_name = 'cur_img_' . uniqid() . '.' . $img_ext; 
        $img_path = '../image/curriculum/' . $new_img_name;
        
        // ย้ายไฟล์ไปที่โฟลเดอร์ (ต้องแน่ใจว่าสร้างโฟลเดอร์ ../image/curriculum/ ไว้แล้ว)
        move_uploaded_file($_FILES['curriculum_img']['tmp_name'], $img_path);
    }

    // 3. จัดการอัปโหลดไฟล์เอกสาร PDF/DOCX (curriculum_file)
    $new_doc_name = "";
    if (isset($_FILES['curriculum_file']) && $_FILES['curriculum_file']['error'] == 0) {
        $doc_ext = pathinfo($_FILES['curriculum_file']['name'], PATHINFO_EXTENSION);
        // สุ่มชื่อไฟล์ใหม่
        $new_doc_name = 'cur_doc_' . uniqid() . '.' . $doc_ext; 
        $doc_path = 'docs/' . $new_doc_name;
        
        // ย้ายไฟล์ไปที่โฟลเดอร์ (ต้องแน่ใจว่าสร้างโฟลเดอร์ docs/ ไว้แล้วในโฟลเดอร์เดียวกับไฟล์นี้)
        move_uploaded_file($_FILES['curriculum_file']['tmp_name'], $doc_path);
    }

    // 4. คำสั่ง SQL สำหรับเพิ่มข้อมูล
    $sql = "INSERT INTO curriculum (
                curriculum_name, 
                curriculum_img, 
                curriculum_detail, 
                curriculum_duration, 
                curriculum_career, 
                curlavel_id, 
                curriculum_file
            ) VALUES (
                '$curriculum_name', 
                '$new_img_name', 
                '$curriculum_detail', 
                '$curriculum_duration', 
                '$curriculum_career', 
                '$curlavel_id', 
                '$new_doc_name'
            )";

    // 5. สั่งรัน SQL และเช็คผลลัพธ์
    $result = mysqli_query($condb, $sql);

    if ($result) {
        // บันทึกสำเร็จ ให้เด้งกลับไปหน้าจัดการหลักสูตร
        echo "<script>
                window.location.href = 'manage_curriculum.php';
              </script>";
    } else {
        // บันทึกไม่สำเร็จ แสดง Error
        echo "<script>
                alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($condb) . "');
                window.history.back();
              </script>";
    }

    mysqli_close($condb);
} else {
    // ถ้าไม่ได้เข้ามาผ่านฟอร์ม ให้เด้งกลับ
    header("Location: manage_curriculum.php");
    exit();
}
?>