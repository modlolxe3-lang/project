<?php

include("condb.php");


$personal_id = $_GET["personal_id"];
// echo $personal_id;die;

$sql = "DELETE FROM personal WHERE personal_id = '$personal_id'";
$result = mysqli_query($condb, $sql);


if($result){
    // echo "ลบข้อมูลสำเร็จ";
    header("Location: manage_personal.php");
}else{
    echo "ลบข้อมูลไม่สำเร็จ";
}

mysqli_close($conn);

?>