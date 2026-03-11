<?php
// 🔑 เชื่อมต่อฐานข้อมูล
include("secure/condb.php");

// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // รับค่าและป้องกัน SQL Injection
    $contact_name = mysqli_real_escape_string($conn, $_POST['name']);
    $contact_email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $contact_message = mysqli_real_escape_string($conn, $_POST['message']);
    $contact_date = date("Y-m-d H:i:s");

    // คำสั่ง SQL บันทึกข้อมูล
    $sql = "INSERT INTO tbl_contact (contact_name, contact_email, contact_subject, contact_message, contact_date) 
            VALUES ('$contact_name', '$contact_email', '$contact_subject', '$contact_message', '$contact_date')";

    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500&display=swap" rel="stylesheet">
        <style>
            body { font-family: "Prompt", sans-serif; }
            .swal2-styled.swal2-confirm {
                background-color: #ff69b4 !important; /* สีชมพูหลัก */
                box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3) !important;
            }
        </style>
    </head>
    <body>';

    if (mysqli_query($conn, $sql)) {
        // ✅ กรณีบันทึกสำเร็จ
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: '<span style=\"color: #ff69b4;\">ส่งข้อความเรียบร้อยแล้ว</span>',
                text: 'ขอบคุณที่ติดต่อเรา เราจะดำเนินการตอบกลับโดยเร็วที่สุด',
                confirmButtonText: 'ตกลง',
            }).then((result) => {
                window.location.href = 'index.php'; // กลับไปหน้าหลัก
            });
        </script>";
    } else {
        // ❌ กรณีเกิดข้อผิดพลาด
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'ขออภัย...',
                text: 'ไม่สามารถบันทึกข้อมูลได้: " . mysqli_error($conn) . "',
                confirmButtonText: 'ลองใหม่',
            }).then((result) => {
                window.history.back();
            });
        </script>";
    }

    echo '</body></html>';
} else {
    // ป้องกันการเข้าถึงไฟล์โดยตรง
    header("Location: index.php");
    exit();
}
?>