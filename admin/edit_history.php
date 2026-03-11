
<?php

include("condb.php");

$id = $_POST["id"];
$history_detail = $_POST["history_detail"];

$sql = "UPDATE 
            tbl_history
            SET
            history_detail = '$history_detail'
            WHERE id =  '$id'
            ";
$result = mysqli_query($condb, $sql);

if($result){
    echo "บันทึกสำเร็จ";
    header("Location: manage_history.php");
    
}else {
    echo "ไม่สามารถบันทึกข้อมูลได้...";
}
?>