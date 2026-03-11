<?php
// 1. เชื่อมต่อฐานข้อมูล (อ้างอิงไฟล์ของคุณ หรือตั้งค่าใหม่ตรงนี้)
include("secure/condb.php");

// หากไฟล์ secure/condb.php ยังไม่มี ให้ใช้การตั้งค่านี้แทน:
/*
$host = "localhost";
$user = "root";
$pass = "";
$db   = "isfact";
$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_set_charset($conn, "utf8mb4");
*/

// --- 2. Logic ดึงข้อมูลจากฐานข้อมูล ---

// แก้ไข: ดึงรูปแบนเนอร์ล่าสุดจาก tbl_banner (ให้เชื่อมกับหน้าแอดมิน)
$sql_banner = "SELECT image FROM tbl_banner ORDER BY id DESC LIMIT 1";
$res_banner = mysqli_query($conn, $sql_banner);
$banner_img = ($res_banner && mysqli_num_rows($res_banner) > 0)
    ? "image/banner/" . mysqli_fetch_array($res_banner)['image']
    : "image/night.jpg"; // รูป Default กรณีฐานข้อมูลว่างเปล่า

// ดึงข้อมูลหลักสูตร (6 รายการ)
$res_curriculum = mysqli_query($conn, "SELECT * FROM curriculum ORDER BY curriculum_id DESC LIMIT 6");

// ดึงข้อมูลข่าวสาร (3 รายการ)
$res_news = mysqli_query($conn, "SELECT * FROM news ORDER BY news_date DESC LIMIT 3");

// นับจำนวนสถิติ
$sql_teacher = mysqli_query($conn, "SELECT COUNT(personal_id) as total FROM personal WHERE lavel_id = 2");
$count_teacher = mysqli_fetch_assoc($sql_teacher)['total'] ?? 0;

$sql_cur_count = mysqli_query($conn, "SELECT COUNT(curriculum_id) as total FROM curriculum");
$count_cur = mysqli_fetch_assoc($sql_cur_count)['total'] ?? 0;
?>

<!DOCTYPE html>
<html class="no-js" lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>สาขาระบบสารสนเทศ - IS RMUTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.2.0.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/css/main.css" />

    <style>
        :root {
            --pink-main: #ff69b4;
            --pink-soft: #ff85c2;
            --pink-light: #fff0f5;
        }

        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fa;
        }

        .hero-area {
            /* แก้ไข: นำตัวแปร $banner_img มาแสดงผลแบบไดนามิก */
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?php echo $banner_img; ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 180px 0;
        }

        /* =========================================
           ✨ ส่วนปรับแต่ง Dropdown เมนูย่อย ✨
           ========================================= */
        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.15);
            padding: 8px;
            background: #ffffff;
            min-width: 250px;
            /* 💡 ปรับความกว้างของกล่องเมนูรวมตรงนี้ */
            margin-top: 10px !important;
        }

        .dropdown-item {
            /* 💡 ปรับขนาดของช่อง: เลขแรกคือ บน-ล่าง (ความสูง), เลขหลังคือ ซ้าย-ขวา (ความกว้างขอบใน) */
            padding: 12px 20px !important;

            /* 💡 ปรับขนาดตัวอักษรในเมนูย่อยตรงนี้ */
            font-size: 16px;

            color: #333333 !important;
            font-weight: 500;
            border-radius: 10px;
            margin-bottom: 5px;
            /* ระยะห่างระหว่างช่อง */
            border-left: 4px solid transparent;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
        }

        .dropdown-item:hover {
            background-color: var(--pink-light) !important;
            color: var(--pink-main) !important;
            padding-left: 25px !important;
            /* ดันข้อความไปทางขวาเมื่อชี้ */
            border-left: 4px solid var(--pink-main);
            transform: scale(1.05);
            /* 💡 ขยายขนาดช่อง 5% (ปรับเลข 1.05 ได้ตามต้องการ) */
            z-index: 6;
            box-shadow: 0 8px 15px rgba(255, 105, 180, 0.2);
        }

        .breadcrumbs h1 {
            color: #fff;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .breadcrumbs p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        /* --- Detail Content Styling --- */
        .curriculum-detail-section {
            padding: 60px 0;
        }

        .img-showcase {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            object-fit: cover;
            border: 5px solid #fff;
        }

        .theme-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #f0f0f0;
        }

        .theme-card:hover {
            transform: translateY(-8px);
            border-color: var(--pink-soft);
        }

        .card-img-container {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .theme-card:hover .card-img-container img {
            transform: scale(1.1);
        }

        .card-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 15px;
        }

        .date-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(45deg, var(--pink-main), var(--pink-soft));
            color: white;
            padding: 8px 12px;
            border-radius: 12px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon"><span></span><span></span></div>
        </div>
    </div>

    <?php include("header.php"); ?>

    <section id="home" class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="hero-content">
                        <h1 class="wow fadeInLeft" data-wow-delay=".4s" style="font-weight: 800; color: #fff;">
                            Information System</h1>
                        <p class="wow fadeInLeft" data-wow-delay=".6s"
                            style="font-weight: 600; font-size: 18px; color: #fff;">
                            สาขาระบบสารสนเทศ คณะบริหารธุรกิจ มทร.อีสาน <br>
                            มุ่งผลิตบัณฑิตนักปฏิบัติที่มีทักษะด้านเทคโนโลยีดิจิทัลและนวัตกรรมธุรกิจ
                        </p>
                        <div class="button wow fadeInLeft" data-wow-delay="0.8s">
                            <a href="#features" class="btn btn-primary">ดูหลักสูตรที่เปิดสอน</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features section">
        <div class="container">
            <div class="section-title text-center">
                <h3 class="wow zoomIn" data-wow-delay=".2s" style="color:var(--pink-main);">หลักสูตรของเรา</h3>
                <h2 class="wow fadeInUp" data-wow-delay=".4s">Programs</h2>
                <p class="wow fadeInUp" data-wow-delay=".6s">
                    เลือกศึกษาในหลักสูตรที่ทันสมัยและตอบโจทย์ตลาดงานในยุคดิจิทัล</p>
            </div>

            <div class="row">
                <?php if ($res_curriculum && mysqli_num_rows($res_curriculum) > 0): ?>
                    <?php while ($row_cur = mysqli_fetch_array($res_curriculum)):
                        // จัดการรูปภาพ: หากไม่มีรูปให้ใช้ no-image.jpg
                        $img_path = (!empty($row_cur['curriculum_img'])) ? "image/curriculum/" . $row_cur['curriculum_img'] : "assets/images/no-image.jpg";
                        ?>
                        <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex align-items-stretch">
                            <a href="curriculum_detail.php?curriculum_id=<?php echo $row_cur['curriculum_id']; ?>"
                                class="text-decoration-none w-100">
                                <div class="theme-card wow fadeInUp" data-wow-delay=".2s">
                                    <div class="card-img-container">
                                        <img src="<?php echo $img_path; ?>"
                                            alt="<?php echo htmlspecialchars($row_cur['curriculum_name']); ?>">
                                    </div>
                                    <div class="card-content">
                                        <h3 class="card-title"><?php echo htmlspecialchars($row_cur['curriculum_name']); ?></h3>
                                        <div class="mt-auto">
                                            <span class="read-more-text">
                                                อ่านรายละเอียดเพิ่มเติม <i class="lni lni-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="empty-state">
                            <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">ยังไม่มีข้อมูลหลักสูตรในขณะนี้</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section" style="background-color: var(--pink-light); padding: 60px 0;">
        <div class="container">
            <div class="section-title text-center">
                <h3 style="color:var(--pink-main);">ข่าวประชาสัมพันธ์</h3>
                <h2>Latest News</h2>
            </div>
            <div class="row">
                <?php while ($row_news = mysqli_fetch_array($res_news)):
                    $news_img = (!empty($row_news['news_img'])) ? "image/news/" . $row_news['news_img'] : "assets/images/no-image.jpg";
                    $news_date = ($row_news['news_date'] != '0000-00-00') ? strtotime($row_news['news_date']) : time();
                    ?>
                    <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex align-items-stretch">
                        <div class="theme-card wow fadeInUp" data-wow-delay=".2s">
                            <div class="card-img-container">
                                <a href="news_detail.php?id=<?php echo $row_news['news_id']; ?>">
                                    <img src="<?php echo $news_img; ?>"
                                        alt="<?php echo htmlspecialchars($row_news['news_name']); ?>">
                                </a>
                                <div class="date-badge">
                                    <span class="day"
                                        style="display:block; font-weight:700;"><?php echo date('d', $news_date); ?></span>
                                    <span class="month" style="font-size:11px;"><?php echo date('M', $news_date); ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">
                                    <a href="news_detail.php?id=<?php echo $row_news['news_id']; ?>"
                                        style="color: inherit;"><?php echo htmlspecialchars($row_news['news_name']); ?></a>
                                </h3>
                                <p style="color: #666; font-size: 0.9rem; margin-bottom: 20px;">
                                    <?php echo mb_strimwidth(strip_tags($row_news['news_detail']), 0, 100, "..."); ?>
                                </p>
                                <div class="mt-auto border-top pt-3">
                                    <a href="news_detail.php?id=<?php echo $row_news['news_id']; ?>"
                                        style="color: var(--pink-main); font-weight: 600;">อ่านต่อ <i
                                            class="lni lni-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <section class="our-achievement section">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="single-achievement wow fadeInUp" data-wow-delay=".2s">
                        <h3 class="counter"><span class="countup" cup-end="100">100</span>%</h3>
                        <p>ความพึงพอใจ</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="single-achievement wow fadeInUp" data-wow-delay=".4s">
                        <h3 class="counter"><span class="countup"
                                cup-end="<?php echo $count_teacher; ?>"><?php echo $count_teacher; ?></span></h3>
                        <p>คณาจารย์ผู้เชี่ยวชาญ</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="single-achievement wow fadeInUp" data-wow-delay=".6s">
                        <h3 class="counter"><span class="countup"
                                cup-end="<?php echo $count_cur; ?>"><?php echo $count_cur; ?></span></h3>
                        <p>หลักสูตรที่เปิดสอน</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php"); ?>

    <a href="#" class="scroll-top"><i class="lni lni-chevron-up"></i></a>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/count-up.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        new WOW().init();
        var cu = new counterUp({ start: 0, duration: 2000, intvalues: true, interval: 100 });
        cu.start();
    </script>
</body>

</html>