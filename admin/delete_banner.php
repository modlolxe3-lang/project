<?php

include("condb.php");


$id = $_GET["id"];
// echo $id;die;

$sql = "DELETE FROM tbl_banner WHERE id = '$id'";
$result = mysqli_query($condb, $sql);


if($result){
    // echo "ลบข้อมูลสำเร็จ";
    header("Location: manage_banner.php");
}else{
    echo "ลบข้อมูลไม่สำเร็จ";
}

mysqli_close($conn);

?>