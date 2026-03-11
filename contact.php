<?php include("header.php"); ?>
<?php
// 🔑 เรียกไฟล์เชื่อมต่อฐานข้อมูล
include("secure/condb.php");

// ดึงข้อมูลพื้นฐาน (หากมีตารางตั้งค่า) หรือกำหนดค่าคงที่
// ในที่นี้สมมติว่าเป็นข้อมูลของสาขาระบบสารสนเทศ มทร.อีสาน
?>

<!DOCTYPE html>
<html class="no-js" lang="th">

<head>
    <meta charset="utf-8" />
    <title>ติดต่อเรา - IS RMUTI</title>
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
            --pink-gradient: linear-gradient(135deg, #ff69b4 0%, #ff85c2 100%);
        }

        body {
            font-family: 'Prompt', sans-serif;
            background-color: #fdfafb;
        }

        /* --- Breadcrumbs --- */
        .breadcrumbs {
            padding: 80px 0;
            background: linear-gradient(rgba(255, 105, 180, 0.9), rgba(255, 133, 194, 0.8)), url('image/NIGHTIMAGE.jpg');
            background-size: cover;
            background-position: center;
        }

        .breadcrumbs h2 {
            color: #fff;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
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

        /* --- Contact Section --- */
        .contact-section {
            padding: 80px 0;
        }

        .contact-info-card {
            background: #fff;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(255, 105, 180, 0.1);
            height: 100%;
            border: 1px solid var(--pink-light);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .info-item .icon {
            width: 50px;
            height: 50px;
            background: var(--pink-light);
            color: var(--pink-main);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .info-item h4 {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .info-item p {
            color: #666;
            margin: 0;
        }

        /* --- Contact Form --- */
        .contact-form-card {
            background: #fff;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            font-weight: 700;
            color: var(--pink-main);
            margin-bottom: 25px;
            border-left: 5px solid var(--pink-main);
            padding-left: 15px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 20px;
            border: 1px solid #eee;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: var(--pink-soft);
            box-shadow: 0 0 0 0.25 margin-bottom: 20px;
            rem rgba(255, 105, 180, 0.25);
        }

        .btn-send {
            background: var(--pink-gradient);
            color: #fff;
            border: none;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            width: 100%;
            transition: 0.3s;
        }

        .btn-send:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 105, 180, 0.3);
            color: #fff;
        }

        /* --- Map --- */
        .map-container {
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="breadcrumb-text">
                        <h2 class="wow fadeInLeft" data-wow-delay=".2s">ติดต่อเรา</h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <ul class="breadcrumb-nav wow fadeInRight" data-wow-delay=".2s">
                        <li><a href="index.php">หน้าแรก</a></li>
                        <li> / ติดต่อเรา</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-12 mb-4">
                    <div class="contact-info-card wow fadeInLeft" data-wow-delay=".3s">
                        <h3 class="mb-4" style="font-weight: 800; color: #333;">ช่องทางการติดต่อ</h3>

                        <div class="info-item">
                            <div class="icon"><i class="lni lni-map-marker"></i></div>
                            <div>
                                <h4>ที่อยู่</h4>
                                <p>สาขาระบบสารสนเทศ คณะบริหารธุรกิจ มทร.อีสาน <br> 744 ถ.สุรนารายณ์ ต.ในเมือง อ.เมือง
                                    จ.นครราชสีมา 30000</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="icon"><i class="lni lni-phone"></i></div>
                            <div>
                                <h4>เบอร์โทรศัพท์</h4>
                                <p>044-233-000 ต่อ 3400</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="icon"><i class="lni lni-envelope"></i></div>
                            <div>
                                <h4>อีเมล</h4>
                                <p>is.ba@rmuti.ac.th</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="icon"><i class="lni lni-facebook-filled"></i></div>
                            <div>
                                <h4>Facebook</h4>
                                <p>Information System RMUTI</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-12 mb-4">
                    <div class="contact-form-card wow fadeInRight" data-wow-delay=".3s">
                        <h3 class="form-title">ส่งข้อความถึงเรา</h3>
                        <form action="contact_process.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="ชื่อ-นามสกุล"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="อีเมลของคุณ"
                                        required>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="subject" class="form-control" placeholder="หัวข้อติดต่อ"
                                        required>
                                </div>
                                <div class="col-12">
                                    <textarea name="message" rows="5" class="form-control"
                                        placeholder="ข้อความของคุณ..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-send">ส่งข้อความ <i
                                            class="lni lni-telegram-original"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row">
                    <div class="col-12">
                        <div class="map-container wow fadeInUp" data-wow-delay=".5s"
                            style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #fff;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1416.1259969407604!2d102.11782837001515!3d14.987164117991675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31194c7f8d28800f%3A0x374c64f368137a67!2z4LiE4LiT4Liw4Lia4Lij4Li04Lir4Liy4Lij4LiY4Li44Lij4LiB4Li04LiI!5e0!3m2!1sen!2sth!4v1772697539531!5m2!1sen!2sth"
                                width="1400" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
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