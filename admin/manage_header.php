<?php
include("header.php");
include("condb.php");

if (!isset($conn)) {
    $conn = $condb;
}

// ดึงข้อมูลโลโก้
$logo_res = mysqli_query($conn, "SELECT setting_value FROM site_settings WHERE setting_key='site_logo'");
$logo_data = ($logo_res && mysqli_num_rows($logo_res) > 0) ? mysqli_fetch_assoc($logo_res) : ['setting_value' => 'logotest.png'];
?>

<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<style>
    .card-header-navy { background: #001f3f linear-gradient(180deg, #26415c, #001f3f) repeat-x !important; color: #ffffff; }
    .text-pink { color: #ff69b4 !important; }
    .btn-pink { background-color: #ff69b4; color: white; }
    .btn-pink:hover { background-color: #ff85c2; color: white; }
    /* เพิ่ม Style เพื่อแยกเมนูหลักและย่อยให้ชัดเจน */
    .row-parent { background-color: rgba(0, 31, 63, 0.05); font-weight: bold; }
    .row-sub { background-color: #ffffff; }
</style>

<?php include("left-menu.php") ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>จัดการส่วนหัวเว็บไซต์ (Header)</h1></div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header card-header-navy"><h3 class="card-title"><i class="fas fa-image"></i> โลโก้เว็บไซต์</h3></div>
                        <form action="header_action.php" method="POST" enctype="multipart/form-data" class="card-body text-center">
                            <div class="p-3 mb-3 border rounded bg-light">
                                <img src="../image/<?php echo $logo_data['setting_value']; ?>" style="max-height: 80px;" alt="Current Logo">
                            </div>
                            <div class="form-group text-left">
                                <label>เปลี่ยนรูปโลโก้ (.png เท่านั้น)</label>
                                <div class="custom-file">
                                    <input type="file" name="logo_file" class="custom-file-input" id="logoFile" accept="image/png" required>
                                    <label class="custom-file-label" for="logoFile">เลือกไฟล์...</label>
                                </div>
                            </div>
                            <button type="submit" name="update_logo" class="btn btn-pink btn-block shadow-sm"><i class="fas fa-save"></i> อัปเดตโลโก้</button>
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header card-header-navy"><h3 class="card-title"><i class="fas fa-bars"></i> จัดการเมนู (Navbar)</h3></div>
                        <div class="card-body">
                            <form action="header_action.php" method="POST" class="row mb-4 p-3 bg-light rounded border">
                                <div class="col-md-12"><label class="text-primary"><i class="fas fa-plus-circle"></i> เพิ่มเมนูใหม่</label></div>
                                <div class="col-md-4 mb-2"><input type="text" name="menu_name" class="form-control" placeholder="ชื่อเมนู" required></div>
                                <div class="col-md-4 mb-2"><input type="text" name="menu_link" class="form-control" placeholder="ลิงก์ (เช่น index.php)" required></div>
                                <div class="col-md-4 mb-2">
                                    <select name="parent_id" class="form-control">
                                        <option value="0">เป็นเมนูหลัก (Parent)</option>
                                        <?php
                                        $p_dropdown = mysqli_query($conn, "SELECT id, menu_name FROM navbar_menu WHERE parent_id=0 ORDER BY sort_order ASC");
                                        while ($pd = mysqli_fetch_assoc($p_dropdown)) { echo "<option value='{$pd['id']}'>เมนูย่อยของ: {$pd['menu_name']}</option>"; }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2"><input type="number" name="sort_order" class="form-control" value="0" title="ลำดับ"></div>
                                <div class="col-md-4 mb-2"><button type="submit" name="add_menu" class="btn btn-success btn-block"><i class="fas fa-plus"></i> เพิ่มเมนู</button></div>
                            </form>

                            <table id="menuTable" class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="10%" class="text-center">ลำดับ</th>
                                        <th>ชื่อเมนู</th>
                                        <th>ลิงก์</th>
                                        <th width="20%" class="text-center">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // 1. ดึงเมนูหลัก
                                    $query_parents = mysqli_query($conn, "SELECT * FROM navbar_menu WHERE parent_id = 0 ORDER BY sort_order ASC");
                                    while ($p = mysqli_fetch_assoc($query_parents)):
                                        $p_id = $p['id'];
                                    ?>
                                        <tr class="row-parent">
                                            <td class="text-center"><span class="badge badge-primary"><?php echo $p['sort_order']; ?></span></td>
                                            <td><i class="fas fa-folder text-warning"></i> <b><?php echo $p['menu_name']; ?></b></td>
                                            <td><code><?php echo $p['menu_link']; ?></code></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-warning btn-sm edit-btn" data-id="<?php echo $p['id']; ?>" data-name="<?php echo htmlspecialchars($p['menu_name']); ?>" data-link="<?php echo htmlspecialchars($p['menu_link']); ?>" data-sort="<?php echo $p['sort_order']; ?>" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                                                <a href="header_action.php?delete=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ลบเมนูหลัก? เมนูย่อยจะถูกลบไปด้วย')"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                        // 2. ดึงเมนูย่อยของเมนูหลักนี้
                                        $query_subs = mysqli_query($conn, "SELECT * FROM navbar_menu WHERE parent_id = $p_id ORDER BY sort_order ASC");
                                        while ($s = mysqli_fetch_assoc($query_subs)):
                                        ?>
                                            <tr class="row-sub">
                                                <td class="text-center text-muted"><?php echo $s['sort_order']; ?></td>
                                                <td style="padding-left: 40px;"><span class="text-muted">└─</span> <i class="far fa-file-alt text-xs text-pink"></i> <?php echo $s['menu_name']; ?></td>
                                                <td><small class="text-muted"><?php echo $s['menu_link']; ?></small></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-warning btn-sm edit-btn" data-id="<?php echo $s['id']; ?>" data-name="<?php echo htmlspecialchars($s['menu_name']); ?>" data-link="<?php echo htmlspecialchars($s['menu_link']); ?>" data-sort="<?php echo $s['sort_order']; ?>" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                                                    <a href="header_action.php?delete=<?php echo $s['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('ลบเมนูย่อยนี้?')"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="header_action.php" method="POST" class="modal-content">
            <div class="modal-header card-header-navy text-white">
                <h5 class="modal-title">แก้ไขข้อมูลเมนู</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group"><label>ชื่อเมนู</label><input type="text" name="menu_name" id="edit_name" class="form-control" required></div>
                <div class="form-group"><label>ลิงก์ (URL)</label><input type="text" name="menu_link" id="edit_link" class="form-control" required></div>
                <div class="form-group"><label>ลำดับ</label><input type="number" name="sort_order" id="edit_sort" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="submit" name="edit_menu" class="btn btn-primary">บันทึก</button>
            </div>
        </form>
    </div>
</div>

<?php include("footer.php"); ?>

<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
    $(document).ready(function () {
        bsCustomFileInput.init();

        $("#menuTable").DataTable({
            "responsive": true,
            "autoWidth": false,
            "ordering": false, // *** สำคัญมาก: ปิดการเรียงลำดับเพื่อให้โชว์ตามที่ PHP เรียงมา ***
            "paging": false,   // ปิดหน้าเพื่อให้อ่านโครงสร้างเมนูได้ต่อเนื่อง
            "info": false,
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json" }
        });

        $('.edit-btn').on('click', function () {
            $('#edit_id').val($(this).data('id'));
            $('#edit_name').val($(this).data('name'));
            $('#edit_link').val($(this).data('link'));
            $('#edit_sort').val($(this).data('sort'));
        });
    });
</script>