<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&display=swap" rel="stylesheet">

<style>
body {

    font-family: 'Sarabun', sans-serif;

}
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="main.php" class="brand-link">
        <img src="../image/logoback1.png" alt="AdminLTE Logo" width="100%" height="100%" style="width: 100%; height: 100%;">
        <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../build/dist/img/admin.png" class="img-circle elevation-2" alt="User Image" height="100%">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION["personal_name"]; ?></a>
                <a href="#" class="d-block"><?php echo $_SESSION["lavel_name"]; ?>
                </a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            จัดการข้อมูลผู้ใช้งาน
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="frm_add_user.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เพิ่มข้อมูลผู้ใช้งาน</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="manage_users.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>จัดการข้อมูลผู้ใช้งาน</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="approve_adduser.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>อนุมัติผู้ใช้งาน</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            จัดการข้อมูลบุคลากร
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="frm_add_personal.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เพิ่มข้อมูลบุคลากร</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="manage_personal.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>จัดการข้อมูลบุคลากร</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon 	fas fa-edit"></i>
                    <!-- <i class="nav-icon fa fa-users"></i> -->
                        <p>
                            จัดการข้อมูลเว็บไซต์
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="manage_history.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ข้อมูลประวัติสาขา</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="manage_dekrmuti.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ข้อมูลการรับสมัคร</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="manage_banner.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รูปภาพ Banner</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="manage_header.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>จัดการเมนู</p>
                            </a>
                        </li>
                    </ul>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon 	fas fa-edit"></i>
                   
                    <!-- <i class="nav-icon fa fa-users"></i> -->
                        <p>
                            จัดการข้อมูลข่าวสาร
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="frm_add_news.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เพิ่มข้อมูลข่าวสาร</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="manage_news.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>จัดการข้อมูลข่าวสาร</p>
                            </a>
                        </li>
                    </ul>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon 	fas fa-edit"></i>
                    <!-- <i class="nav-icon fa fa-users"></i> -->
                    
                        <p>
                            จัดการข้อมูลหลักสูตร
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="frm_add_curriculum.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เพิ่มข้อมูลหลักสูตร</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="manage_curriculum.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>จัดการข้อมูลหลักสูตร</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="manage_curlavel.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>จัดการประเภทหลักสูตร</p>
                            </a>
                        </li>
                    </ul>
                    
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            รายงาน
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="report_pie.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ผลรายงาน</p>
                            </a>
                        </li>
                    </ul>
                <!-- <li class="nav-item">
                    <a href="../widgets.html" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            ผู้พัฒนาระบบ
                            <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>