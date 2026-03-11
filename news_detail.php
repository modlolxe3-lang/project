<?php include("header.php"); ?>
<?php 
// 🔑 เรียกไฟล์เชื่อมต่อฐานข้อมูล
include("secure/condb.php"); 

// 1. รับค่า ID จาก URL และป้องกัน SQL Injection
$news_id = mysqli_real_escape_string($conn, $_GET['id']);

// 2. ดึงข้อมูลข่าวสารตาม ID (JOIN กับหมวดหมู่ข่าว)
$sql_news = "SELECT n.*, t.titlenews_name 
             FROM news n 
             LEFT JOIN titlenews t ON n.titlenews_id = t.titlenews_id 
             WHERE n.news_id = '$news_id'";
$res_news = mysqli_query($conn, $sql_news);
$row_news = mysqli_fetch_array($res_news);

// ถ้าไม่พบข้อมูลให้กลับหน้าหลัก
if(!$row_news){
    echo "<script>window.location='index.php';</script>";
    exit;
}

// 3. ดึงข่าวสารอื่นๆ 4 รายการล่าสุด (ไม่เอาข่าวปัจจุบัน)
$sql_recent = "SELECT * FROM news WHERE news_id != '$news_id' ORDER BY news_id DESC LIMIT 4";
$res_recent = mysqli_query($conn, $sql_recent);
?>

<!DOCTYPE html>
<html class="no-js" lang="th">

<head>
    <meta charset="utf-8" />
    <title><?php echo $row_news['news_name']; ?> - IS RMUTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.2.0.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/css/main.css" />

    <style>
        :root {
            --pink-main: #e91e63;
            --pink-light: #fce4ec;
            --pink-dark: #ad1457;
        }

        body {
            font-family: 'Prompt', sans-serif;
            background-color: #fffafc; /* พื้นหลังขาวอมชมพูอ่อน */
        }

        /* --- Breadcrumbs (หัวเพจ) --- */
         .breadcrumbs {
            background: linear-gradient(45deg, var(--pink-main), #ff85c2);
            padding: 60px 0;
            text-align: #;
        }

        .breadcrumbs h2 {
            color: #fff;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .breadcrumb-nav li {
            display: inline-block;
            color: #fff;
        }

        .breadcrumb-nav li a {
            color: #fff;
            opacity: 0.8;
            text-decoration: none;
        }

        /* --- Content Card --- */
        .news-details-area { padding: 60px 0; }

        .content-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 25px;
            border: 1px solid rgba(255, 105, 180, 0.1);
            box-shadow: 0 15px 35px rgba(255, 105, 180, 0.1);
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
            min-width: 250px; /* 💡 ปรับความกว้างของกล่องเมนูรวมตรงนี้ */
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
            margin-bottom: 5px; /* ระยะห่างระหว่างช่อง */
            border-left: 4px solid transparent;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); 
            position: relative; 
        }

        .dropdown-item:hover {
            background-color: var(--pink-light) !important;
            color: var(--pink-main) !important;
            padding-left: 25px !important; /* ดันข้อความไปทางขวาเมื่อชี้ */
            border-left: 4px solid var(--pink-main);
            transform: scale(1.05); /* 💡 ขยายขนาดช่อง 5% (ปรับเลข 1.05 ได้ตามต้องการ) */
            z-index: 6; 
            box-shadow: 0 8px 15px rgba(255, 105, 180, 0.2); 
        }

        .main-img-container {
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .main-img {
            width: 100%;
            height: auto;
            transition: transform 0.5s ease;
        }

        .meta-info {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .meta-item {
            background: var(--pink-light);
            color: var(--pink-main);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
        }

        .news-title {
            font-weight: 800;
            color: #333;
            line-height: 1.4;
            margin-bottom: 25px;
            border-left: 6px solid var(--pink-main);
            padding-left: 20px;
        }

        .news-text {
            color: #555;
            line-height: 1.9;
            font-size: 17px;
            text-align: justify;
        }

        /* --- Sidebar (ข่าวล่าสุด) --- */
        .sidebar {
            background: #fff;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid var(--pink-light);
        }

        .sidebar-title {
            font-weight: 700;
            font-size: 20px;
            color: var(--pink-main);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .sidebar-title::after {
            content: '';
            flex-grow: 1;
            height: 2px;
            background: var(--pink-light);
            margin-left: 15px;
        }

        .recent-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 10px;
            border-radius: 15px;
        }

        .recent-item:hover {
            background: var(--pink-light);
            transform: translateX(5px);
        }

        .recent-thumb {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
            margin-right: 15px;
        }

        .recent-info h4 {
            font-size: 15px;
            color: #444;
            margin-bottom: 5px;
            font-weight: 600;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .recent-info span {
            font-size: 12px;
            color: #999;
        }

        /* --- Button --- */
        .btn-back {
            background: var(--pink-gradient);
            color: white !important;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
            transition: 0.3s;
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 105, 180, 0.4);
        }
    </style>
</head>

<body>

    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="breadcrumb-text">
                        <h2 class="wow fadeInLeft" data-wow-delay=".2s">ข่าวสารและกิจกรรม</h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <ul class="breadcrumb-nav wow fadeInRight" data-wow-delay=".2s">
                        <li><a href="index.php">หน้าแรก</a></li>
                        <li> / รายละเอียดข่าว</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="news-details-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="content-card wow fadeInUp" data-wow-delay=".3s">
                        
                        <div class="main-img-container">
                            <?php 
                                $img_path = (!empty($row_news['news_img'])) ? "image/news/".$row_news['news_img'] : "assets/images/no-image.jpg";
                            ?>
                            <img src="<?php echo $img_path; ?>" alt="News Image" class="main-img">
                        </div>

                        <div class="meta-info">
                            <div class="meta-item"><i class="lni lni-calendar"></i> <?php echo date('d/m/Y', strtotime($row_news['news_date'])); ?></div>
                            <div class="meta-item"><i class="lni lni-tag"></i> <?php echo $row_news['titlenews_name']; ?></div>
                            <div class="meta-item"><i class="lni lni-timer"></i> <?php echo $row_news['news_time']; ?> น.</div>
                        </div>

                        <h2 class="news-title"><?php echo $row_news['news_name']; ?></h2>

                        <div class="news-text">
                            <?php echo nl2br($row_news['news_detail']); ?>
                        </div>
                        
                        <hr class="my-5" style="border-top: 1px solid #eee;">
                        
                        <div class="button">
                            <a href="index.php" class="btn btn-back"><i class="lni lni-arrow-left"></i> กลับหน้าหลัก</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="sidebar wow fadeInRight" data-wow-delay=".5s">
                        <h3 class="sidebar-title">ข่าวสารล่าสุด</h3>
                        <div class="recent-list">
                            <?php while($recent = mysqli_fetch_array($res_recent)) { 
                                $r_img = (!empty($recent['news_img'])) ? "image/news/".$recent['news_img'] : "assets/images/no-image.jpg";
                            ?>
                            <a href="news_detail.php?id=<?php echo $recent['news_id']; ?>" class="recent-item">
                                <img src="<?php echo $r_img; ?>" class="recent-thumb">
                                <div class="recent-info">
                                    <h4><?php echo $recent['news_name']; ?></h4>
                                    <span><i class="lni lni-calendar"></i> <?php echo date('d M Y', strtotime($recent['news_date'])); ?></span>
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php"); ?>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
</body>

</html>