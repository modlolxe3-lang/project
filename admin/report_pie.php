<?php
include("header.php");
include("condb.php");

// ตรวจสอบการเชื่อมต่อฐานข้อมูลให้รองรับทั้ง $conn และ $condb
if (!isset($conn)) {
    $conn = $condb;
}

// 1. แก้ไข: เตรียมข้อมูลจากตาราง academic (เนื่องจากไม่มีตาราง research)
$years = [];
$academicCounts = [];
$sql_academic = "SELECT YEAR(academic_date) AS a_year, COUNT(*) AS total 
                 FROM academic 
                 GROUP BY a_year 
                 ORDER BY a_year ASC";
$res_academic = mysqli_query($conn, $sql_academic);

if (mysqli_num_rows($res_academic) > 0) {
    while($row = mysqli_fetch_assoc($res_academic)){
        $years[] = "'" . ($row['a_year'] + 543) . "'"; 
        $academicCounts[] = $row['total'];
    }
} else {
    // กรณีไม่มีข้อมูลให้แสดงปีปัจจุบันเป็น 0
    $years[] = "'" . (date('Y') + 543) . "'";
    $academicCounts[] = 0;
}

// 2. เตรียมข้อมูลสัดส่วนบุคลากรตามระดับ (lavel)
$pLabels = [];
$pData = [];
$sql_personnel = "SELECT l.lavel_name, COUNT(p.personal_id) as total 
                  FROM lavel l 
                  LEFT JOIN personal p ON l.lavel_id = p.lavel_id 
                  GROUP BY l.lavel_id";
$res_personnel = mysqli_query($conn, $sql_personnel);
while($row = mysqli_fetch_assoc($res_personnel)){
    $pLabels[] = "'" . $row['lavel_name'] . "'";
    $pData[] = $row['total'];
}

// 3. เตรียมข้อมูลข่าวสารรายเดือน (ปีปัจจุบัน)
$months = ["'ม.ค.'", "'ก.พ.'", "'มี.ค.'", "'เม.ย.'", "'พ.ค.'", "'มิ.ย.'", "'ก.ค.'", "'ส.ค.'", "'ก.ย.'", "'ต.ค.'", "'พ.ย.'", "'ธ.ค.'"];
$newsCounts = array_fill(0, 12, 0);
$sql_news = "SELECT MONTH(news_date) AS m, COUNT(*) AS total 
             FROM news 
             WHERE YEAR(news_date) = YEAR(CURDATE())
             GROUP BY m";
$res_news = mysqli_query($conn, $sql_news);
while($row = mysqli_fetch_assoc($res_news)){
    $newsCounts[$row['m']-1] = $row['total'];
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<style>
    .card-header-navy { background: #001f3f linear-gradient(180deg, #26415c, #001f3f) repeat-x !important; color: #ffffff; }
    .text-pink { color: #ff69b4 !important; }
    .report-card { border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-bottom: 25px; border: none; }
    .chart-container { position: relative; height: 300px; width: 100%; }
</style>

<?php include("left-menu.php") ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-chart-bar text-pink"></i> รายงานสถิติภาพรวม</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card report-card">
                        <div class="card-header card-header-navy">
                            <h3 class="card-title"><i class="fas fa-book"></i> จำนวนผลงานวิชาการแยกตามปี (พ.ศ.)</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-container"><canvas id="barAcademic"></canvas></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card report-card">
                        <div class="card-header card-header-navy">
                            <h3 class="card-title"><i class="fas fa-users"></i> สัดส่วนบุคลากรตามตำแหน่ง</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-container"><canvas id="piePersonnel"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card report-card shadow">
                        <div class="card-header card-header-navy">
                            <h3 class="card-title"><i class="fas fa-newspaper"></i> สถิติการลงข่าวสารรายเดือน (ปีปัจจุบัน)</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="height: 350px;"><canvas id="lineNews"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("footer.php"); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script>
    const chartColors = ['#ff69b4', '#001f3f', '#36b9cc', '#f6c23e', '#e74a3b', '#1cc88a', '#4e73df'];

    // 1. กราฟแท่งผลงานวิชาการ (แก้ไขจาก Research)
    new Chart(document.getElementById('barAcademic'), {
        type: 'bar',
        data: {
            labels: [<?php echo implode(',', $years); ?>],
            datasets: [{
                label: 'ผลงานวิชาการ (เรื่อง)',
                data: [<?php echo implode(',', $academicCounts); ?>],
                backgroundColor: '#001f3f',
                hoverBackgroundColor: '#ff69b4'
            }]
        },
        options: { 
            maintainAspectRatio: false,
            scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
        }
    });

    // 2. กราฟโดนัทบุคลากร
    new Chart(document.getElementById('piePersonnel'), {
        type: 'doughnut',
        data: {
            labels: [<?php echo implode(',', $pLabels); ?>],
            datasets: [{
                data: [<?php echo implode(',', $pData); ?>],
                backgroundColor: chartColors,
                borderWidth: 2
            }]
        },
        options: { 
            maintainAspectRatio: false,
            cutoutPercentage: 65,
            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15 } }
        }
    });

    // 3. กราฟเส้นข่าวสาร
    new Chart(document.getElementById('lineNews'), {
        type: 'line',
        data: {
            labels: [<?php echo implode(',', $months); ?>],
            datasets: [{
                label: 'จำนวนข่าวสาร',
                data: [<?php echo implode(',', $newsCounts); ?>],
                borderColor: '#ff69b4',
                backgroundColor: 'rgba(255, 105, 180, 0.1)',
                pointBackgroundColor: '#001f3f',
                pointRadius: 5,
                fill: true,
                tension: 0.4
            }]
        },
        options: { 
            maintainAspectRatio: false,
            scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
        }
    });
</script>