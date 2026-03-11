<?php

include("condb.php");


$teacher_id = $_GET["teacher_id"];


$sql = "DELETE FROM teachers WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($condb, $sql);


if($result){
    // echo "ลบข้อมูลสำเร็จ";
    header("Location: manage_tab.php");
}else{
    echo "ลบข้อมูลไม่สำเร็จ";
}

mysqli_close($conn);

?>