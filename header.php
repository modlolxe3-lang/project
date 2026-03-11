<?php 
// 1. ตรวจสอบและเชื่อมต่อฐานข้อมูล
if (file_exists('admin/condb.php')) {
    include 'admin/condb.php'; 
} elseif (file_exists('condb.php')) {
    include 'condb.php';
}

// เช็คกรณีชื่อตัวแปรเชื่อมต่อฐานข้อมูลไม่ตรงกัน
if (!isset($conn) && isset($condb)) { $conn = $condb; }

// ดึงโลโก้จากฐานข้อมูล (ถ้าไม่มีให้ใช้ logotest.png เป็นค่าเริ่มต้น)
$logo_q = mysqli_query($conn, "SELECT setting_value FROM site_settings WHERE setting_key='site_logo'");
$logo_src = ($logo_q && mysqli_num_rows($logo_q) > 0) ? mysqli_fetch_assoc($logo_q)['setting_value'] : 'logotest.png';
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สาขาวิชาระบบสารสนเทศ</title>

    <link rel="stylesheet" href="test/style.css">
    <link rel="stylesheet" href="test/plugins.css">
    <link rel="stylesheet" href="../build/dist/css/adminlte.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <style>
        :root {
            --pink-main: #ff69b4;
            --pink-soft: #ff85c2;
            --pink-light: #fff0f5;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --transition-smooth: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        body {
            font-family: 'Prompt', sans-serif;
            margin-top: 90px;
            /* เว้นที่สำหรับ Navbar */
            background-color: #f8f9fa;
        }

        /* --- Navbar Styling --- */
        .navbar {
            background-color: var(--glass-bg) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 105, 180, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 15px 0 !important;
            /* ปรับความสูงตรงนี้ */
            transition: var(--transition-smooth);
        }

        .navbar-hidden {
            transform: translateY(-100%);
            opacity: 0;
        }

        /* --- Nav Links --- */
        .nav-link {
            color: #2d3436 !important;
            font-weight: 500;
            padding: 8px 20px !important;
            position: relative;
            transition: var(--transition-smooth);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--pink-main);
            transition: var(--transition-smooth);
            transform: translateX(-50%);
        }

        .nav-link:hover {
            color: var(--pink-main) !important;
        }

        .nav-link:hover::after {
            width: 60%;
        }

        /* --- Dropdown Menu --- */
        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.15);
            padding: 10px 0px;
            background: #ffffff;
            min-width: 180px;
        }

        /* --- สไตล์ของช่องเมนู (Dropdown Item) --- */
        .dropdown-item {
            /* 1. ส่วนปรับขนาดของ "ช่อง" (Box Size) */
            padding: 6px 10px;
            /* เลข 12px คือความกว้าง บน-ล่าง (ความสูงช่อง), เลข 20px คือ ซ้าย-ขวา */
            min-height: 20px;
            /* กำหนดความสูงขั้นต่ำของช่องให้ดูโปร่งขึ้น */
            margin-bottom: 2px;
            /* ระยะห่างระหว่างช่องแต่ละช่อง */
            border-radius: 10px;
            /* ความโค้งมนของมุมกล่อง */

            /* 2. ส่วนปรับ "ข้อความ" (Text Style) */
            font-size: 6px;
            /* ขนาดตัวอักษร (เปลี่ยนตัวเลขเพื่อขยายหรือลดขนาด) */
            color: #333333 !important;
            /* สีของตัวอักษรตอนปกติ */
            font-weight: 300;
            /* ความหนาของตัวอักษร (400=ปกติ, 500=หนานิดๆ, 700=หนามาก) */
            text-align: left;
            /* การจัดวางตัวอักษร ชิดซ้าย */

            /* 3. เอฟเฟกต์พื้นฐาน (ไม่ต้องแก้) */
            border-left: 4px solid transparent;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
        }

        /* --- เมื่อเมาส์ชี้ (Hover) --- */
        .dropdown-item:hover {
            background-color: var(--pink-light) !important;

            /* สีตัวอักษร และ ขนาดตัวอักษร ตอนที่เมาส์ชี้ */
            color: var(--pink-main) !important;
            /* เปลี่ยนสีข้อความตอนเมาส์ชี้ได้ที่นี่ */

            /* การขยายขนาดช่องตอนเมาส์ชี้ */
            padding-left: 25px;
            /* ดันข้อความไปทางขวานิดหน่อยให้ดูมีมิติ */
            border-left: 4px solid var(--pink-main);
            transform: scale(1.05);
            /* ขยายขนาดช่อง 5% */
            z-index: 6;
            box-shadow: 0 8px 15px rgba(255, 105, 180, 0.2);
        }

        /* --- Logo --- */
        .custom-logo {
            width: 160px;
            height: auto;
            transition: var(--transition-smooth);
            filter: brightness(0);
            /* ปรับเป็นสีดำตามความต้องการเดิม */
        }

        .navbar-brand:hover .custom-logo {
            transform: scale(1.05);
        }

        /* --- Button Login --- */
        .btn-login {
            background: linear-gradient(45deg, var(--pink-main), var(--pink-soft));
            color: white !important;
            border-radius: 50px;
            padding: 8px 25px !important;
            font-weight: 500;
            border: none;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
        }
    </style>
</head>

<body>
    <nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="image/<?php echo $logo_src; ?>" alt="Logo" class="custom-logo">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php 
                    // ดึงข้อมูลเมนูจากฐานข้อมูลมาแสดงแทน HTML เดิม
                    $main_q = mysqli_query($conn, "SELECT * FROM navbar_menu WHERE parent_id = 0 ORDER BY sort_order ASC");
                    if ($main_q) {
                        while($m = mysqli_fetch_assoc($main_q)):
                            $mid = $m['id'];
                            $sub_q = mysqli_query($conn, "SELECT * FROM navbar_menu WHERE parent_id = '$mid' ORDER BY sort_order ASC");
                            $has_sub = ($sub_q && mysqli_num_rows($sub_q) > 0);
                    ?>
                        <li class="nav-item <?php echo $has_sub ? 'dropdown' : ''; ?>">
                            <a class="nav-link <?php echo $has_sub ? 'dropdown-toggle' : ''; ?>" 
                               href="<?php echo $m['menu_link']; ?>" 
                               <?php echo $has_sub ? 'id="drop_'.$mid.'" data-bs-toggle="dropdown"' : ''; ?>>
                                <?php echo $m['menu_name']; ?>
                            </a>
                            
                            <?php if($has_sub): ?>
                                <ul class="dropdown-menu">
                                    <?php while($s = mysqli_fetch_assoc($sub_q)): ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo $s['menu_link']; ?>">
                                                <?php echo $s['menu_name']; ?>
                                            </a>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php 
                        endwhile;
                    } 
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNav">
        <div class="offcanvas-header" style="background: var(--pink-main);">
            <h5 class="offcanvas-title text-white">เมนูหลัก</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <?php 
                // ดึงเมนูหลักอีกรอบมาลงในส่วนของ Offcanvas มือถือ
                if ($main_q) {
                    mysqli_data_seek($main_q, 0); 
                    while($m = mysqli_fetch_assoc($main_q)): 
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $m['menu_link']; ?>">
                            <?php echo $m['menu_name']; ?>
                        </a>
                    </li>
                <?php 
                    endwhile; 
                } 
                ?>
            </ul>
        </div>
    </div>

    <script>
        // Script สำหรับซ่อน/แสดง Navbar เมื่อ Scroll
        let lastScrollTop = 0;
        const navbar = document.getElementById('mainNavbar');

        window.addEventListener('scroll', function () {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                navbar.classList.add('navbar-hidden');
            } else {
                navbar.classList.remove('navbar-hidden');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    </script>
</body>

</html>