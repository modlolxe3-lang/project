<?php

include("condb.php");

$history_detail = $_POST["history_detail"];



$sql = "INSERT INTO tbl_history
            (history_detail)VALUES('$history_detail'
                            )";
                            
$result = mysqli_query($condb, $sql);

if($result){
    // echo "บันทึกสำเร็จ";
    header("Location: manage_history.php");

}else {
    echo "ไม่สามารถบันทึกข้อมูลได้...";
}

?>