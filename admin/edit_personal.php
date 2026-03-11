<?php

include("condb.php");

$personal_id = $_POST["id"];
$personal_name = $_POST["personal_name"];
$personal_position = $_POST["personal_position"];
$bachelor_degree = $_POST["bachelor_degree"];
$master_degree = $_POST["master_degree"];
$doctorate_degree = $_POST["doctorate_degree"];
$personal_performace = $_POST["personal_performace"];
$personal_email = $_POST["personal_email"];
$personal_tel = $_POST["personal_tel"];

// Check if an image file was uploaded
if(isset($_FILES["personal_img"]) && $_FILES["personal_img"]["error"] === 0) {
    // Set the target directory for uploading images
    $target_directory = "../image/personal/";
    // Get the image name
    $image_name = $_FILES["personal_img"]["name"];
    // Set the target path
    $target_path = $target_directory . $image_name;
    // Move the uploaded file to the target directory
    if(move_uploaded_file($_FILES["personal_img"]["tmp_name"], $target_path)) {
        // If the file was uploaded successfully, update the database
        $sql = "UPDATE personal
                SET
                    personal_img = '$image_name',
                    personal_name = '$personal_name',
                    personal_position = '$personal_position',
                    bachelor_degree = '$bachelor_degree',
                    master_degree = '$master_degree',
                    doctorate_degree = '$doctorate_degree',
                    personal_performace = '$personal_performace',
                    personal_email = '$personal_email',
                    personal_tel = '$personal_tel'
                WHERE personal_id = '$personal_id'";
        $result = mysqli_query($condb, $sql);
        if($result) {
            // If the update was successful, redirect to the management page
            header("Location: manage_personal.php");
            exit();
        } else {
            // If the update failed, display an error message
            echo "ไม่สามารถบันทึกข้อมูลได้...";
        }
    } else {
        // If the image file could not be moved to the target directory, display an error message
        echo "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ...";
    }
} else {
    // If no image file was uploaded, update the database without updating the image field
    $sql = "UPDATE personal
            SET
                personal_name = '$personal_name',
                personal_position = '$personal_position',
                bachelor_degree = '$bachelor_degree',
                master_degree = '$master_degree',
                doctorate_degree = '$doctorate_degree',
                personal_performace = '$personal_performace',
                personal_email = '$personal_email',
                personal_tel = '$personal_tel'
            WHERE personal_id = '$personal_id'";
    $result = mysqli_query($condb, $sql);
    if($result) {
        // If the update was successful, redirect to the management page
        header("Location: manage_personal.php");
        exit();
    } else {
        // If the update failed, display an error message
        echo "ไม่สามารถบันทึกข้อมูลได้...";
    }
}

?>
