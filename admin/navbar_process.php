<?php
include('conf.php');

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $link = $_POST['link'];
    $pid = $_POST['parent_id'];
    $sort = $_POST['sort'];
    mysqli_query($conn, "INSERT INTO navbar_menu (menu_name, menu_link, parent_id, sort_order) VALUES ('$name', '$link', '$pid', '$sort')");
    header("Location: manage_navbar.php");
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM navbar_menu WHERE menu_id = $id OR parent_id = $id");
    header("Location: manage_navbar.php");
}
?>