<?php
// 1. นำเข้าไฟล์เชื่อมต่อฐานข้อมูล (ต้องให้แน่ใจว่าไฟล์ condb.php อยู่ในโฟลเดอร์เดียวกัน)
require_once "condb.php"; 

// 2. ตรวจสอบการเชื่อมต่อฐานข้อมูลว่าใช้งานได้หรือไม่
if (!isset($conn)) {
    // ถ้าใน condb.php คุณใช้ตัวแปรชื่อ $condb ให้สลับมาใช้ $conn ให้ตรงกับโค้ดด้านล่าง
    if(isset($condb)) {
        $conn = $condb; 
    } else {
        die("Error: ไม่พบตัวแปรเชื่อมต่อฐานข้อมูล โปรดตรวจสอบไฟล์ condb.php");
    }
}

// --- จัดการโลโก้ ---
if (isset($_POST['update_logo'])) {
    $file = $_FILES['logo_file'];
    if ($file['name'] != "") {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_name = "logo_" . time() . "." . $ext;
        
        // กำหนดพาร์ทไปที่โฟลเดอร์ image (ถอยกลับ 1 ขั้น เพราะไฟล์นี้อยู่ใน admin)
        $path = "../image/" . $new_name;

        if (move_uploaded_file($file['tmp_name'], $path)) {
            $sql_logo = "UPDATE site_settings SET setting_value = '$new_name' WHERE setting_key = 'site_logo'";
            mysqli_query($conn, $sql_logo);
        }
    }
    header("Location: manage_header.php");
    exit(); // ใส่ exit หลัง header เสมอเพื่อหยุดการทำงานของสคริปต์
}

// --- เพิ่มเมนู ---
if (isset($_POST['add_menu'])) {
    $name = mysqli_real_escape_string($conn, $_POST['menu_name']);
    $link = mysqli_real_escape_string($conn, $_POST['menu_link']);
    $parent = (int)$_POST['parent_id']; // แปลงเป็นตัวเลขเพื่อความปลอดภัย
    $sort = (int)$_POST['sort_order'];
    
    $sql_add = "INSERT INTO navbar_menu (menu_name, menu_link, parent_id, sort_order) 
                VALUES ('$name', '$link', '$parent', '$sort')";
    mysqli_query($conn, $sql_add);
    
    header("Location: manage_header.php");
    exit();
}

// --- แก้ไขเมนู ---
if (isset($_POST['edit_menu'])) {
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['menu_name']);
    $link = mysqli_real_escape_string($conn, $_POST['menu_link']);
    $sort = (int)$_POST['sort_order'];
    
    $sql_edit = "UPDATE navbar_menu SET 
            menu_name = '$name', 
            menu_link = '$link', 
            sort_order = '$sort' 
            WHERE id = '$id'";
            
    if (mysqli_query($conn, $sql_edit)) {
        echo "<script>alert('แก้ไขข้อมูลเรียบร้อย'); window.location='manage_header.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
    exit();
}

// --- ลบเมนู ---
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // ลบทั้งเมนูหลัก และเมนูย่อยที่อ้างอิงถึงเมนูหลักนี้
    $sql_del = "DELETE FROM navbar_menu WHERE id='$id' OR parent_id='$id'";
    mysqli_query($conn, $sql_del);
    
    header("Location: manage_header.php");
    exit();
}
?>