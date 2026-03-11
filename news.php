<?php 
include("header.php");
include("secure/condb.php"); 

// ดึงข้อมูลข่าวสารทั้งหมด (เชื่อมกับตาราง titlenews เพื่อเอาชื่อหมวดหมู่)
$sql_news = "SELECT n.*, t.titlenews_name 
             FROM news n 
             LEFT JOIN titlenews t ON n.titlenews_id = t.titlenews_id 
             ORDER BY n.news_date DESC, n.news_time DESC";
$res_news = mysqli_query($conn, $sql_news);
?>

<!DOCTYPE html>
<html class="no-js" lang="th">
<head>
    <meta charset="utf-8" />
    <title>ข่าวสารและกิจกรรม - IS RMUTI</title>
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

        .breadcrumbs {
            background: linear-gradient(45deg, var(--pink-main), #ff85c2);
            padding: 60px 0;
            text-align: center;
        }
        .breadcrumbs h2 { color: #fff; font-weight: 700; }

        .news-section { padding: 80px 0; background-color: #fff5f8; }

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

        /* News Card Styling */
        .single-news {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(233, 30, 99, 0.05);
            transition: all 0.4s ease;
            height: 100%;
            border: 1px solid #fce4ec;
            display: flex;
            flex-direction: column;
        }
        .single-news:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(233, 30, 99, 0.12);
        }
        .news-img {
            width: 100%;
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        .news-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }
        .single-news:hover .news-img img { transform: scale(1.1); }

        .news-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--pink-main);
            color: #fff;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        .news-content { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; }
        .news-meta { font-size: 13px; color: #ad1457; margin-bottom: 10px; display: flex; align-items: center; }
        .news-meta i { margin-right: 5px; }

        .news-title { font-size: 1.25rem; font-weight: 700; color: #2c3e50; margin-bottom: 15px; line-height: 1.4; }
        .news-title a { color: inherit; text-decoration: none; transition: 0.3s; }
        .news-title a:hover { color: var(--pink-main); }

        .news-detail { color: #666; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px; }

        .btn-news {
            margin-top: auto;
            color: var(--pink-main);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-news i { margin-left: 5px; transition: 0.3s; }
        .btn-news:hover i { transform: translateX(5px); }
    </style>
</head>

<body>
    <div class="breadcrumbs">
        <div class="container">
            <h2 class="wow fadeInUp" data-wow-delay=".2s">ข่าวสารและกิจกรรม</h2>
            <p class="text-white opacity-75">อัปเดตความเคลื่อนไหวล่าสุดของสาขาระบบสารสนเทศ</p>
        </div>
    </div>
    
    <section class="news-section">
        <div class="container">
            <div class="row">
                <?php if(mysqli_num_rows($res_news) > 0) { 
                    while($row = mysqli_fetch_array($res_news)) { 
                        // กำหนดรูปภาพ ถ้าไม่มีให้ใช้รูป Default
                        $img_src = (!empty($row['news_img'])) ? "image/news/".$row['news_img'] : "assets/images/no-image.jpg";
                        // แปลงวันที่ไทย
                        $news_date = date("d/m/Y", strtotime($row['news_date']));
                ?>
                <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex align-items-stretch">
                    <div class="single-news wow fadeInUp" data-wow-delay=".2s">
                        <div class="news-img">
                            <img src="<?php echo $img_src; ?>" alt="news">
                            <span class="news-badge"><?php echo $row['titlenews_name']; ?></span>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span><i class="lni lni-calendar"></i> <?php echo $news_date; ?></span>
                                <span class="ms-3"><i class="lni lni-alarm-clock"></i> <?php echo substr($row['news_time'], 0, 5); ?> น.</span>
                            </div>
                            <h3 class="news-title">
                                <a href="news_detail.php?id=<?php echo $row['news_id']; ?>">
                                    <?php echo mb_strimwidth($row['news_name'], 0, 60, "..."); ?>
                                </a>
                            </h3>
                            <div class="news-detail">
                                <?php echo mb_strimwidth(strip_tags($row['news_detail']), 0, 120, "..."); ?>
                            </div>
                            <a href="news_detail.php?id=<?php echo $row['news_id']; ?>" class="btn-news">
                                อ่านเพิ่มเติม <i class="lni lni-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php } } else { ?>
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">ยังไม่มีข้อมูลข่าวสารในขณะนี้</h4>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include("footer.php"); ?>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script>new WOW().init();</script>
</body>
</html>