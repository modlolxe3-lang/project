<?php
include("../secure/condb.php");

// รับค่า personal_id ที่ส่งมาจากลิงก์หรือปุ่ม
$personal_id = $_GET["personal_id"];

// ทำการอัปเดตฐานข้อมูลเพื่ออนุมัติผู้ใช้งาน
$sql_approve_user = "UPDATE personal SET is_approved = 1 WHERE personal_id = $personal_id";
$result_approve_user = mysqli_query($condb, $sql_approve_user);

// ตรวจสอบการอัปเดตข้อมูล
if ($result_approve_user) {
    // อนุมัติผู้ใช้งานเรียบร้อยแล้ว

    // ดึงอีเมลล์ของผู้ใช้จากฐานข้อมูล
    $sql_get_email = "SELECT personal_email FROM personal WHERE personal_id = $personal_id";
    $result_get_email = mysqli_query($condb, $sql_get_email);
    $row = mysqli_fetch_assoc($result_get_email);
    $user_email = $row['personal_email'];

    // ส่งอีเมลล์
    $to = $user_email;
    $subject = 'การอนุมัติผู้ใช้งาน';
    $message = 'บัญชีของคุณได้รับการอนุมัติแล้ว';
    $headers = 'From: sender@example.com';

    // ส่งอีเมลล์
    mail($to, $subject, $message, $headers);

    // เปลี่ยนเส้นทางไปยังหน้าที่ต้องการ
    header("Location: manage_users.php");
} else {
    echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
}
?>


