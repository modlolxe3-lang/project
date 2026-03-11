<?php
// --- ดึงข้อมูลจากฐานข้อมูลเพื่อมาแสดงใน Footer (ถ้ามีการเชื่อมต่อ $conn ไว้แล้ว) ---
// 1. ดึงหลักสูตรล่าสุด 3 รายการ
$sql_foot_cur = "SELECT * FROM curriculum WHERE isActive = 1 ORDER BY curriculum_id DESC LIMIT 3";
$res_foot_cur = mysqli_query($conn, $sql_foot_cur);

// 2. ดึงข่าวประชาสัมพันธ์ล่าสุด 3 รายการ
$sql_foot_news = "SELECT * FROM news ORDER BY news_id DESC LIMIT 3";
$res_foot_news = mysqli_query($conn, $sql_foot_news);
?>

<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-footer f-about">
                        <div class="logo">
                            <a href="index.php">
                                <img src="image/logotest1.png" alt="Logo IS RMUTI" style="max-width: 180px;">
                            </a>
                        </div>
                        <p>สาขาระบบสารสนเทศ คณะบริหารธุรกิจ มทร.อีสาน <br> 
                           มุ่งผลิตบัณฑิตนักปฏิบัติที่มีทักษะด้านเทคโนโลยีดิจิทัล และนวัตกรรมธุรกิจระดับมืออาชีพ</p>
                        <ul class="social">
                            <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-youtube"></i></a></li>
                        </ul>
                        <p class="copyright-text">
                            <span>© <?php echo date("Y"); ?> IS RMUTI. All Rights Reserved.</span> <br>
                            Designed and Developed by <a href="https://uideck.com/" rel="nofollow" target="_blank">UIdeck</a>
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-footer f-link">
                        <h3>หลักสูตรของเรา</h3>
                        <ul>
                            <?php while($f_cur = mysqli_fetch_array($res_foot_cur)) { ?>
                                <li><a href="curriculum_detail.php?id=<?php echo $f_cur['curriculum_id']; ?>">
                                    <?php echo $f_cur['curriculum_name']; ?>
                                </a></li>
                            <?php } ?>
                            <li><a href="index.php#features">ดูทั้งหมด...</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-footer f-link">
                        <h3>ข่าวประชาสัมพันธ์</h3>
                        <ul>
                            <?php while($f_news = mysqli_fetch_array($res_foot_news)) { ?>
                                <li><a href="news_detail.php?id=<?php echo $f_news['news_id']; ?>">
                                    <i class="lni lni-chevron-right" style="font-size: 10px;"></i> 
                                    <?php echo mb_strimwidth($f_news['news_name'], 0, 40, "..."); ?>
                                </a></li>
                            <?php } ?>
                        </ul>
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
<script src="assets/js/tiny-slider.js"></script>
<script src="assets/js/glightbox.min.js"></script>
<script src="assets/js/count-up.min.js"></script>
<script src="assets/js/main.js"></script>

<script type="text/javascript">
    // ตั้งค่าตัวนับเลข (Counter) สำหรับหน้าเว็บ
    var cu = new counterUp({
        start: 0,
        duration: 2000,
        intvalues: true,
        interval: 100,
        append: " ",
    });
    cu.start();
</script>