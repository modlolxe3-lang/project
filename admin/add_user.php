<?php

include("condb.php");


$personal_name = $_POST["personal_name"];
$personal_username = $_POST["personal_username"];
$personal_tel = $_POST["personal_tel"];
$personal_password = $_POST["personal_password"];
$lavel_id = $_POST["lavel_id"];

$sql = "INSERT INTO personal
            (personal_name, 
            personal_username, 
            personal_tel,
            personal_password,
            lavel_id)VALUES('$personal_name',
                            '$personal_username',
                            '$personal_tel',
                            '$personal_password',
                            '$lavel_id'
                            )";

$result = mysqli_query($condb, $sql);

if($result){
    echo "บันทึกสำเร็จ";
    header("Location: manage_users.php");

}else {
    echo "ไม่สามารถบันทึกข้อมูลได้...";
}

?>