<?php

include("condb.php");


$personal_img = $_POST["personal_img"];
$personal_name = $_POST["personal_name"];
$personal_position = $_POST["personal_position"];
$bachelor_degree = $_POST["bachelor_degree"];
$master_degree = $_POST["master_degree"];
$doctorate_degree = $_POST["doctorate_degree"];
$personal_performace = $_POST["personal_performace"];
$personal_email = $_POST["personal_email"];
$personal_tel = $_POST["personal_tel"];


$sql = "INSERT INTO personal 
            (personal_img, 
            personal_name,
            persona_position, 
            bachelor_degree,
            master_degree,
            doctorate_degree,
            personal_performace,
            personal_email,
            personal_tel )VALUES('$personal_img',
                            '$personal_name',
                            '$personal_position',
                            '$bachelor_degree',
                            '$master_degree',
                            '$doctorate_degree',
                            '$personal_performace',
                            '$personal_email',
                            '$personal_tel'
                            )";
                            
$result = mysqli_query($condb, $sql);

if($result){
    echo "บันทึกสำเร็จ";
    header("Location: manage_personal.php");

}else {
    echo "ไม่สามารถบันทึกข้อมูลได้...";
}

?>
