<?php include("header.php");?>
<?php 
// 🔑 เรียกไฟล์เชื่อมต่อฐานข้อมูล
include("secure/condb.php"); 

// รับค่า ID จาก URL และป้องกัน SQL Injection
$personal_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// ดึงข้อมูลบุคลากรรายบุคคล
$sql_teacher = "SELECT * FROM personal WHERE personal_id = '$personal_id' LIMIT 1";
$res_teacher = mysqli_query($conn, $sql_teacher);
$row = mysqli_fetch_array($res_teacher);

// ตรวจสอบว่าพบข้อมูลหรือไม่ ถ้าไม่พบให้กลับไปหน้า teacher.php
if (!$row) {
    echo "<script>alert('ไม่พบข้อมูลบุคลากร'); window.location='teacher.php';</script>";
    exit;
}

// จัดการเรื่องรูปภาพ (ใช้ personal_img ตามโครงสร้างฐานข้อมูลของคุณ)
$t_img = (!empty($row['personal_img'])) ? "image/personal/".$row['personal_img'] : "assets/images/no-image.jpg";
?>

<!DOCTYPE html>
<html class="no-js" lang="th">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title><?php echo $row['personal_name']; ?> - IS RMUTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.2.0.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/css/main.css" />

    <style>
        :root {
            --pink-dark: #c2185b;
            --pink-main: #ff69b4;
            --pink-light: #fff0f5;
        }

        body { background-color: #fdfbfb; font-family: 'Prompt', sans-serif; }

        /* Profile Header Section */
        .teacher-header {
            padding: 80px 0;
            background: linear-gradient(135deg, #fff 0%, var(--pink-light) 100%);
            border-bottom: 1px solid rgba(255, 105, 180, 0.1);
        }

        .profile-img-container {
            width: 100%;
            max-width: 350px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: 8px solid #fff;
            margin: 0 auto;
        }

        .profile-img-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .info-content h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #2d3436;
            margin-bottom: 10px;
        }

        .info-content .badge-pos {
            display: inline-block;
            padding: 6px 20px;
            background: var(--pink-main);
            color: #fff;
            border-radius: 50px;
            font-size: 1rem;
            margin-bottom: 25px;
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

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--pink-dark);
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .section-title i { margin-right: 10px; }

        .contact-list { list-style: none; padding: 0; }
        .contact-list li {
            margin-bottom: 15px;
            font-size: 1.05rem;
            color: #444;
            display: flex;
            align-items: center;
        }
        .contact-list i {
            width: 35px; height: 35px; line-height: 35px;
            text-align: center; background: var(--pink-light);
            color: var(--pink-main); border-radius: 50%; margin-right: 15px;
        }

        .btn-back {
            background: #636e72;
            color: #fff !important;
            padding: 10px 25px;
            border-radius: 50px;
            transition: 0.3s;
            text-decoration: none;
        }
        .btn-back:hover { background: #2d3436; transform: translateX(-5px); }

        /* ปรับแต่ง Card โดยรวม */
    /* เน้นโทนสีชมพูและขาวสะอาด */
    .detail-section {
        background: #ffffff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(231, 2, 116, 0.05); /* เงาสีชมพูจางๆ */
        height: 100%;
        border: 1px solid #fce4ec; /* เส้นขอบชมพูอ่อน */
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #d81b60; /* สีชมพูเข้ม */
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        border-left: 5px solid #e91e63; /* แถบสีชมพูสด */
        padding-left: 15px;
    }

    /* Timeline การศึกษาในธีมชมพู */
    .edu-timeline {
        position: relative;
        padding-left: 30px;
    }

    .edu-timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 2px;
        background: #f8bbd0; /* เส้นแนวตั้งชมพูอ่อน */
    }

    .edu-item {
        position: relative;
        margin-bottom: 25px;
    }

    .edu-item::before {
        content: '';
        position: absolute;
        left: -34px;
        top: 5px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #e91e63; /* จุดชมพู */
        border: 2px solid #fff;
        box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.2);
    }

    .edu-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #ad1457;
        margin-bottom: 2px;
    }

    .edu-text {
        color: #4a5568;
        font-size: 1.05rem;
    }

    /* ข้อมูลติดต่อสไตล์ไอคอนสีชมพู */
    .contact-list p {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .contact-list i {
        width: 38px;
        height: 38px;
        background: #fce4ec; /* พื้นหลังไอคอนสีชมพูอ่อน */
        color: #e91e63;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1.1rem;
    }

    .contact-list a {
        color: #e91e63;
        text-decoration: none;
        transition: 0.3s;
    }

    .contact-list a:hover {
        color: #ad1457;
        text-decoration: underline;
    }

    /* หมายเหตุนัดหมาย */
    .note-box {
        background-color: #fff0f5; 
        border: 1px dashed #f06292;
        padding: 15px;
        border-radius: 12px;
        font-size: 0.85rem;
        color: #c2185b;
        margin-top: 25px;
    }

    .section-title {
        display: flex; /* จัดให้อยู่บรรทัดเดียวกัน */
        align-items: center; /* จัดให้อยู่กึ่งกลางแนวตั้ง */
        font-size: 1.4rem;
        font-weight: 700;
        color: #d81b60; /* สีชมพูเข้ม */
        border-left: 5px solid #e91e63; /* แถบสีชมพูสดด้านหน้า */
        padding-left: 15px;
        margin-bottom: 25px;
        white-space: nowrap; /* ป้องกันข้อความตัดบรรทัด */
    }

    .section-title i {
        color: #e91e63; /* สีไอคอนชมพู */
        font-size: 1.6rem;
    }

    </style>
</head>

<body>
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon"><span></span><span></span></div>
        </div>
    </div>

    <section class="teacher-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-center mb-4 mb-lg-0">
                    <div class="profile-img-container wow zoomIn">
                        <img src="<?php echo $t_img; ?>" alt="<?php echo $row['personal_name']; ?>">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="info-content wow fadeInRight">
                        <a href="teacher.php" class="btn-back mb-4 d-inline-block">
                            <i class="lni lni-arrow-left"></i> กลับหน้าบุคลากร
                        </a>
                        <h2><?php echo $row['personal_name']; ?></h2>
                        <span class="badge-pos"><?php echo $row['personal_position']; ?></span>
                        
                        <ul class="contact-list mt-3">
                            <li><i class="lni lni-envelope"></i> <?php echo !empty($row['personal_email']) ? $row['personal_email'] : "ไม่มีข้อมูลอีเมล"; ?></li>
                            <li><i class="lni lni-phone"></i> <?php echo !empty($row['personal_tel']) ? $row['personal_tel'] : "ไม่มีข้อมูลเบอร์โทรศัพท์"; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="teacher-details section" style="padding: 80px 0; background-color: #fff5f8;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12 mb-4">
                <div class="detail-section wow fadeInUp">
                    <h3 class="section-title">ประวัติและวุฒิการศึกษา</h3>
                    <div class="edu-timeline">
                        <?php if (!empty($row['doctorate_degree']) && $row['doctorate_degree'] != '-'): ?>
                            <div class="edu-item">
                                <span class="edu-label">ปริญญาเอก</span>
                                <div class="edu-text"><?php echo htmlspecialchars($row['doctorate_degree']); ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($row['master_degree']) && $row['master_degree'] != '-'): ?>
                            <div class="edu-item">
                                <span class="edu-label">ปริญญาโท</span>
                                <div class="edu-text"><?php echo htmlspecialchars($row['master_degree']); ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($row['bachelor_degree']) && $row['bachelor_degree'] != '-'): ?>
                            <div class="edu-item">
                                <span class="edu-label">ปริญญาตรี</span>
                                <div class="edu-text"><?php echo htmlspecialchars($row['bachelor_degree']); ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($row['bachelor_degree']) && empty($row['master_degree']) && empty($row['doctorate_degree'])): ?>
                            <div class="edu-text text-muted italic">
                                <?php echo !empty($row['personal_performace']) ? nl2br($row['personal_performace']) : "อยู่ระหว่างการอัปเดตข้อมูล"; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12 mb-4">
                <div class="detail-section wow fadeInUp" data-wow-delay=".2s">
                    <h3 class="section-title d-flex align-items-center">
                    <i class="lni lni-map-marker" style="margin-right: 10px;"></i> 
                    <span>ข้อมูลการติดต่อ</span>
                    </h3>
                    <div class="contact-list">
                        <p>
                            <i class="lni lni-briefcase"></i>
                            <span><strong>ตำแหน่ง:</strong><br><?php echo !empty($row['personal_position']) ? htmlspecialchars($row['personal_position']) : 'อาจารย์ประจำสาขา'; ?></span>
                        </p>
                        <p>
                            <i class="lni lni-phone"></i>
                            <span><strong>โทรศัพท์:</strong><br><?php echo !empty($row['personal_tel']) ? htmlspecialchars($row['personal_tel']) : '-'; ?></span>
                        </p>
                        <p>
                            <i class="lni lni-envelope"></i>
                            <span><strong>อีเมล:</strong><br><a href="mailto:<?php echo $row['personal_email']; ?>"><?php echo htmlspecialchars($row['personal_email']); ?></a></span>
                        </p>
                        
                        <hr style="border-top: 1px solid #fce4ec; margin: 20px 0;">
                        
                        <p style="align-items: flex-start;">
                            <i class="lni lni-map-marker"></i>
                            <span><strong>สถานที่ทำงาน:</strong><br>
                            <small class="text-muted">สาขาระบบสารสนเทศ คณะบริหารธุรกิจ มทร.อีสาน (นครราชสีมา)</small></span>
                        </p>
                    </div>

                    <div class="note-box">
                        <i class="lni lni-bullhorn"></i> <strong>หมายเหตุ:</strong><br>
                        กรุณานัดหมายล่วงหน้าผ่านทางอีเมลสำหรับการขอเข้าพบ
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>new WOW().init();</script>
</body>
</html>