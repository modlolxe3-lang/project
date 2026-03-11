<?php

    session_start();

    if(session_destroy()){
        header("Location: ../adminis/index.php");
    }else{
        echo "ผิดพลาด, ไม่สามารถออกจากระบบได้...";
    }


?>