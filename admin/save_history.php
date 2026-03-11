<?php
include("condb.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $history_detail = mysqli_real_escape_string($condb, $_POST['history_detail']);
    $history_link = mysqli_real_escape_string($condb, $_POST['history_link']);
    $history_img = "";

    // จัดการอัปโหลดรูปภาพ
    if (isset($_FILES['history_img']) && $_FILES['history_img']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['history_img']['name'], PATHINFO_EXTENSION));
        $new_name = "hist_" . date('Ymd_His') . "_" . rand(100, 999) . "." . $ext;
        $target = "../image/history/" . $new_name;

        if (move_uploaded_file($_FILES['history_img']['tmp_name'], $target)) {
            $history_img = $new_name;
        }
    }

    $sql = "INSERT INTO tbl_history (history_detail, history_link, history_img) 
            VALUES ('$history_detail', '$history_link', '$history_img')";

    if (mysqli_query($condb, $sql)) {
        echo "<script>
                alert('บันทึกข้อมูลสำเร็จ');
                window.location='manage_dekrmuti.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($condb);
    }
}
?>