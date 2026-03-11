<?php
// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$host = "sql100.infinityfree.com";
$user = "if0_41361443";      // ชื่อผู้ใช้งาน (ปกติใน XAMPP คือ root)
$pass = "XZWZ73DrwzcSbe1";          // รหัสผ่าน (ปกติใน XAMPP จะว่างไว้)
$db   = "if0_41361443_isfact";    // ชื่อฐานข้อมูลตามที่ระบุในไฟล์ SQL

// สร้างการเชื่อมต่อ
$conn = mysqli_connect($host, $user, $pass, $db);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตั้งค่าให้รองรับภาษาไทย
mysqli_set_charset($conn, "utf8mb4");

// ตั้งค่า Time Zone (เพื่อให้เวลาในระบบตรงกับเวลาประเทศไทย)
date_default_timezone_set('Asia/Bangkok');

// ตัวแปรเสริมสำหรับใช้งานในบางจุดที่อาจเรียกใช้ชื่อต่างกัน
$condb = $conn; 
?>