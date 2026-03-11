<?php 
include 'condb.php'; 
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM navbar_menu WHERE id = '$id'");
$row = mysqli_fetch_assoc($query);

if (!$row) { header("Location: manage_header.php"); exit; }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขเมนู - Admin</title>
    <link rel="stylesheet" href="../build/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Prompt', sans-serif; background: #f4f6f9; padding-top: 50px; }
        .card-pink { border-top: 3px solid #ff69b4; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-pink shadow">
                    <div class="card-header bg-white">
                        <h3 class="card-title">แก้ไขข้อมูลเมนู</h3>
                    </div>
                    <form action="header_action.php" method="POST">
                        <div class="card-body">
                            <input type="hidden" name="menu_id" value="<?php echo $row['id']; ?>">
                            
                            <div class="form-group">
                                <label>ชื่อเมนู</label>
                                <input type="text" name="menu_name" class="form-control" value="<?php echo $row['menu_name']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>ลิงก์ (URL)</label>
                                <input type="text" name="menu_link" class="form-control" value="<?php echo $row['menu_link']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>ลำดับการแสดงผล (น้อยไปมาก)</label>
                                <input type="number" name="sort_order" class="form-control" value="<?php echo $row['sort_order']; ?>">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="manage_header.php" class="btn btn-secondary">ยกเลิก</a>
                            <button type="submit" name="update_menu" class="btn btn-success">บันทึกการแก้ไข</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>