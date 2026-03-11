<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "isfact";

// ตรวจสอบชื่อตัวแปรตรงนี้ต้องเป็น $conn
$conn = mysqli_connect($host, $user, $pass, $db);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตั้งค่า Font ให้รองรับภาษาไทยตามฐานข้อมูล
mysqli_set_charset($conn, "utf8");
?>