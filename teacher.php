<?php 
// 🔑 เรียกไฟล์ส่วนหัว (ตรวจสอบชื่อไฟล์ให้ถูกต้อง)
include("header.php"); 

// 🔑 เรียกไฟล์เชื่อมต่อฐานข้อมูล 
// ตรวจสอบ path ว่าเป็น "secure/condb.php" หรือ "condb.php" ตามโปรเจกต์ของคุณ
include("secure/condb.php"); 

/** * ตรวจสอบชื่อตัวแปรเชื่อมต่อในไฟล์ condb.php 
 * หากในไฟล์นั้นใช้ $condb ให้เปลี่ยน $conn ในหน้านี้เป็น $condb ทั้งหมดครับ
 **/

// ดึงข้อมูลบุคลากร (ระดับอาจารย์ lavel_id = 2)
$sql_teacher = "SELECT * FROM personal WHERE lavel_id = 2 ORDER BY personal_id ASC";
$res_teacher = mysqli_query($conn, $sql_teacher);
?>
<!DOCTYPE html>
<html class="no-js" lang="th">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>คณาจารย์ - IS RMUTI</title>
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
            --transition-smooth: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        body {
            background-color: #fdfbfb;
            font-family: 'Prompt', sans-serif;
        }

        .teacher-hero {
            padding: 120px 0 80px;
            /* ปรับให้แสดงผลได้แม้ไม่มีไฟล์รูป */
            background: linear-gradient(45deg, rgba(255, 105, 180, 0.9), rgba(255, 133, 194, 0.8)), url('image/NIGHTIMAGE.jpg');
            background-size: cover;
            background-position: center;
            text-align: center;
            color: white;
            margin-bottom: 60px;
        }

        .teacher-area .row {
            display: flex;
            flex-wrap: wrap;
        }

        .teacher-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: var(--transition-smooth);
            border: 1px solid #f0f0f0;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .teacher-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 105, 180, 0.15);
            border-color: var(--pink-soft);
        }

        .teacher-img-wrapper {
            width: 160px;
            height: 160px;
            margin: 40px auto 25px;
            border-radius: 50%;
            overflow: hidden;
            border: 6px solid var(--pink-light);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            flex-shrink: 0;
        }

        .teacher-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .teacher-info {
            padding: 0 25px 35px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .teacher-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 8px;
        }

        .teacher-position {
            background: var(--pink-light);
            color: var(--pink-main);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .teacher-contact {
            font-size: 0.85rem;
            color: #636e72;
            padding-top: 15px;
            border-top: 1px dashed #eee;
            margin-bottom: 20px;
            text-align: left;
        }

        .btn-view-detail {
            margin-top: auto;
            color: var(--pink-main);
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <section class="teacher-hero">
        <div class="container">
            <h2 class="wow fadeInUp" data-wow-delay=".2s">คณาจารย์</h2>
            <p class="wow fadeInUp" data-wow-delay=".4s">
                บุคลากรผู้ทรงคุณวุฒิ สาขาระบบสารสนเทศ คณะบริหารธุรกิจ มทร.อีสาน
            </p>
        </div>
    </section>

    <section class="teacher-area section">
        <div class="container">
            <div class="row">
                <?php
                if ($res_teacher && mysqli_num_rows($res_teacher) > 0) {
                    $delay = 0.2;
                    while ($row = mysqli_fetch_array($res_teacher)) {
                        // ตรวจสอบรูปภาพ ถ้าไม่มีให้ใช้รูป Default
                        $t_img = (!empty($row['personal_img'])) ? "image/personal/" . $row['personal_img'] : "assets/images/no-image.jpg";
                ?>
                        <div class="col-lg-3 col-md-6 col-12 mb-5">
                            <a href="teacher_detail.php?id=<?php echo $row['personal_id']; ?>" class="text-decoration-none h-100 d-block">
                                <div class="teacher-card wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                                    <div class="teacher-img-wrapper">
                                        <img src="<?php echo $t_img; ?>" alt="<?php echo $row['personal_name']; ?>">
                                    </div>
                                    <div class="teacher-info">
                                        <h3 class="teacher-name"><?php echo $row['personal_name']; ?></h3>
                                        <div>
                                            <span class="teacher-position"><?php echo $row['personal_position']; ?></span>
                                        </div>
                                        <div class="teacher-contact">
                                            <?php if (!empty($row['personal_email'])) { ?>
                                                <p class="mb-1"><i class="lni lni-envelope"></i> <?php echo $row['personal_email']; ?></p>
                                            <?php } ?>
                                            <?php if (!empty($row['personal_tel'])) { ?>
                                                <p class="mb-0"><i class="lni lni-phone"></i> <?php echo $row['personal_tel']; ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="btn-view-detail text-center">
                                            ดูประวัติเพิ่มเติม <i class="lni lni-arrow-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php
                        $delay += 0.1;
                        if ($delay > 0.8) $delay = 0.2; // Reset delay เพื่อไม่ให้รอนานเกินไป
                    }
                } else {
                    echo "<div class='col-12 text-center'><p>ไม่พบข้อมูลคณาจารย์ในระบบ</p></div>";
                }
                ?>
            </div>
        </div>
    </section>

    <?php include("footer.php"); ?>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        new WOW().init();
    </script>
</body>

</html>