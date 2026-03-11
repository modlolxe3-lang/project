<?php

include("condb.php");

// Validate and sanitize inputs
$teacher_name = mysqli_real_escape_string($condb, $_POST["teacher_name"]);
$description = mysqli_real_escape_string($condb, $_POST["description"]);
$youtube_link = mysqli_real_escape_string($condb, $_POST["youtube_link"]);

// File upload handling
$image_name = $_FILES["image_name"]["name"]; // Assuming the input name for the file is "image_name"
$image_temp = $_FILES["image_name"]["tmp_name"];
$image_path = "../image/tab/" . basename($image_name); // Adjust the path as needed

// Move the uploaded file to the desired location
if (move_uploaded_file($image_temp, $image_path)) {
    // File uploaded successfully, proceed with database insertion
    $sql = "INSERT INTO teachers 
                (teacher_name, 
                image_name, 
                description,
                youtube_link)
            VALUES
                ('$teacher_name',
                '$image_name',
                '$description',
                '$youtube_link')";

    $result = mysqli_query($condb, $sql);

    if ($result) {
        // Redirect upon successful insertion
        header("Location: manage_tab.php");
        exit; // Make sure to exit after redirection
    } else {
        // Database insertion failed
        echo "ไม่สามารถบันทึกข้อมูลได้...";
    }
} else {
    // File upload failed
    echo "ไม่สามารถอัพโหลดรูปภาพได้...";
}

?>
