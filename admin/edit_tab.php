<?php

include("condb.php");

$teacher_id = $_POST["id"];
$teacher_name = $_POST["teacher_name"];
$description = $_POST["description"];
$youtube_link = $_POST["youtube_link"];

// File upload handling
$target_dir = "../image/tab/";
$target_file = $target_dir . basename($_FILES["image_name"]["name"]);
$image_name = $_FILES["image_name"]["name"];
$image_tmp = $_FILES["image_name"]["tmp_name"];

// Move uploaded file to the specified directory
if (move_uploaded_file($image_tmp, $target_file)) {
    // Update teacher information in the database
    $sql = "UPDATE 
                teachers
                SET
                teacher_name = '$teacher_name',
                image_name = '$image_name',
                description = '$description',
                youtube_link = '$youtube_link'
                WHERE teacher_id = '$teacher_id'";
    $result = mysqli_query($condb, $sql);

    if ($result) {
        echo "บันทึกสำเร็จ";
        header("Location: manage_tab.php");
    } else {
        echo "ไม่สามารถบันทึกข้อมูลได้...";
    }
} else {
    echo "ไม่สามารถอัปโหลดไฟล์รูปภาพได้";
}
?>
