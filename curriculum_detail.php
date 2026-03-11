<?php
include("header.php");
include("secure/condb.php");

// 1. รับค่า ID จาก URL และป้องกัน SQL Injection เบื้องต้น
$cur_id = isset($_GET['curriculum_id']) ? mysqli_real_escape_string($conn, $_GET['curriculum_id']) : 1;

// 2. ดึงข้อมูลจากฐานข้อมูล
$sql_cur = "SELECT * FROM curriculum WHERE curriculum_id = '$cur_id'";
$res_cur = mysqli_query($conn, $sql_cur);
$row_cur = mysqli_fetch_array($res_cur);

// กรณีไม่พบข้อมูลใน DB (อาจจะใส่ ID มั่วมา)
if (!$row_cur) {
    echo "<script>alert('ไม่พบข้อมูลหลักสูตรที่ระบุ'); window.location='index.php';</script>";
    exit;
}

// 3. จัดการรูปภาพ
$img_path = (!empty($row_cur['curriculum_img'])) ? "image/curriculum/" . $row_cur['curriculum_img'] : "assets/images/no-image.jpg";

// 4. จัดการไฟล์เอกสาร (ถ้าใน DB มีคอลัมน์เก็บชื่อไฟล์ PDF)
$pdf_link = (!empty($row_cur['curriculum_file'])) ? "uploads/" . $row_cur['curriculum_file'] : "uploads/curriculum_default.pdf";
?>
<!DOCTYPE html>
<html class="no-js" lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title><?php echo $row_cur['curriculum_name'] ?? 'หลักสูตร ป.ตรี คอมพิวเตอร์ธุรกิจ (ต่อเนื่อง)'; ?> - IS RMUTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.2.0.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <style>
        :root {
            --pink-main: #ff69b4;
            --pink-soft: #ff85c2;
            --pink-light: #fff0f5;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --transition-smooth: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fa;
        }

        /* --- Page Header / Breadcrumb --- */
        .breadcrumbs {
            background: linear-gradient(135deg, var(--pink-main) 0%, #ff85c2 100%);
            padding: 60px 0 40px;
            text-align: center;
            color: #fff;
            margin-top: 80px;
        }

        /* Dropdown Styling */
        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.15);
            padding: 8px;
            background: #ffffff;
            min-width: 250px;
            margin-top: 10px !important;
        }

        .dropdown-item {
            padding: 12px 20px !important;
            font-size: 16px;
            color: #333333 !important;
            font-weight: 500;
            border-radius: 10px;
            margin-bottom: 5px;
            border-left: 4px solid transparent;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
        }

        .dropdown-item:hover {
            background-color: var(--pink-light) !important;
            color: var(--pink-main) !important;
            padding-left: 25px !important;
            border-left: 4px solid var(--pink-main);
            transform: scale(1.05);
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

        .detail-card,
        .sidebar-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(255, 105, 180, 0.08);
            transition: var(--transition-smooth);
            will-change: transform;
        }

        .detail-card {
            padding: 40px;
            border-top: 5px solid var(--pink-main);
        }

        .sidebar-card {
            background: var(--pink-light);
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
        }

        .detail-card:hover,
        .sidebar-card:hover {
            transform: scale(1.03) translateY(-5px);
            box-shadow: 0 15px 35px rgba(255, 105, 180, 0.15);
            z-index: 5;
            position: relative;
        }

        .detail-card h3 {
            color: var(--pink-main);
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px dashed var(--pink-light);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-card h3 i {
            font-size: 1.8rem;
        }

        .content-body {
            color: #555;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .btn-download {
            background: linear-gradient(45deg, var(--pink-main), var(--pink-soft));
            color: white !important;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 500;
            display: inline-block;
            transition: var(--transition-smooth);
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
            width: 100%;
            text-align: center;
        }

        .btn-download:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(255, 105, 180, 0.4);
        }

        .sidebar-card-pink {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem 1.5rem;
            box-shadow: 0 10px 30px rgba(236, 72, 153, 0.08);
            border: 1px solid rgba(236, 72, 153, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar-card-pink:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(236, 72, 153, 0.15);
        }

        .pink-icon-box {
            width: 70px;
            height: 70px;
            background: #fdf2f8;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #ec4899;
        }

        .sidebar-card-pink h4 {
            color: #374151;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .sidebar-card-pink h4::after {
            content: '';
            display: block;
            width: 35px;
            height: 4px;
            background: #ec4899;
            margin: 0.6rem auto 0;
            border-radius: 10px;
        }

        .career-list-pink {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .career-list-pink li {
            position: relative;
            padding-left: 28px;
            margin-bottom: 12px;
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .career-list-pink li i {
            position: absolute;
            left: 0;
            top: 4px;
            color: #ec4899;
            font-size: 1rem;
        }

        .duration-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ec4899;
            background: #fdf2f8;
            padding: 10px 20px;
            border-radius: 12px;
            display: inline-block;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="wow fadeInUp" data-wow-delay=".2s">
                        <?php echo $row_cur['curriculum_name']; ?>
                    </h1>
                    <p class="wow fadeInUp" data-wow-delay=".4s">
                        <?php echo $row_cur['curriculum_year'] ?? '(หลักสูตรใหม่ พ.ศ. 2562)'; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <section class="curriculum-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-4 wow fadeInLeft" data-wow-delay=".2s">
                    <img src="<?php echo $img_path; ?>" alt="ภาพหลักสูตร" class="img-showcase img-fluid">

                    <div class="detail-card">
                        <h3><i class="fa-solid fa-laptop-code"></i> รายละเอียดหลักสูตร</h3>
                        <div class="content-body">
                            <?php 
                            echo (!empty($row_cur['curriculum_detail'])) 
                                 ? $row_cur['curriculum_detail'] 
                                 : "<p class='text-muted'>กำลังปรับปรุงข้อมูลรายละเอียดหลักสูตร...</p>"; 
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 wow fadeInRight" data-wow-delay=".4s">
                    
                    <div class="sidebar-card-pink text-center">
                        <div class="pink-icon-box">
                            <i class="fa-solid fa-clock fa-2x"></i>
                        </div>
                        <h4>ระยะเวลาการศึกษา</h4>
                        <div class="duration-text">
                            <?php echo $row_cur["curriculum_duration"] ?: "ไม่มีข้อมูลระบุ"; ?>
                        </div>
                    </div>

                    <br>

                    <div class="sidebar-card-pink text-center">
                        <div class="pink-icon-box">
                            <i class="fa-solid fa-briefcase fa-2x"></i>
                        </div>
                        <h4>สายงานอาชีพที่รองรับ</h4>
                        <div class="text-start">
                            <ul class="career-list-pink">
                                <?php
                                if (!empty($row_cur["curriculum_career"])) {
                                    $careers = explode("\n", str_replace("\r", "", $row_cur["curriculum_career"]));
                                    foreach ($careers as $job) {
                                        $job = trim($job);
                                        if (!empty($job)) {
                                            echo '<li><i class="fa-solid fa-circle-check"></i> ' . htmlspecialchars($job) . '</li>';
                                        }
                                    }
                                } else {
                                    echo '<li class="text-center text-muted"><em>ไม่มีข้อมูลระบุ</em></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <br>

                    <div class="sidebar-card bg-white" style="border: 2px solid var(--pink-light);">
                        <h4><i class="fa-solid fa-file-pdf text-danger"></i> เอกสารหลักสูตร</h4>
                        <p class="text-muted" style="font-size: 0.9rem;">ดาวน์โหลดโครงสร้างหลักสูตรแบบเต็ม</p>
                        <a href="<?php echo $pdf_link; ?>" target="_blank" class="btn-download">
                            <i class="fa-solid fa-download"></i> ดาวน์โหลด PDF
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="single-footer f-about">
                            <div class="Logo">
                                <a href="index.php">
                                    <img src="image/logofooter.png" alt="Logo">
                                </a>
                            </div>
                            <p>Information System, RMUTI. <br> ผลิตบัณฑิตนักปฏิบัติ มืออาชีพด้านระบบสารสนเทศ</p>
                            <p class="copyright-text">Designed and Developed by <a href="https://uideck.com/"
                                    rel="nofollow" target="_blank">UIdeck</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>