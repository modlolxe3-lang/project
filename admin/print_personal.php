<?php

use Mpdf\Tag\Td;

// Include database connection
include("condb.php");

// SQL query to select records
$sql = "SELECT * FROM personal WHERE lavel_id ='2' ";
$result = mysqli_query($condb, $sql);
$numrow = mysqli_num_rows($result);

// Include MPDF library
require_once __DIR__ . '/vendor/autoload.php';

// Configure MPDF font directories and font data
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

// Create MPDF object with font configuration
$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/vendor/mpdf/mpdf/ttfonts',
    ]),
    'fontdata' => $fontData + [
        'frutiger' => [
            'R' => 'THSarabun.ttf',
            'I' => 'THSarabun.ttf',
        ]
    ],
    'default_font' => 'frutiger'
]);

// HTML content for the PDF
$html = "<h1>คณาจารย์ประจำสาขาระบบสารสนเทศ</h1><table border='1' width='100%' style='font-size: 18px;'>
    <tr style='background-color:#CB135B'>
        <th>รูปภาพ</th>
        <th>ชื่ออาจารย์</th>
        <th>การศึกษา</th>
        <th>ผลงาน</th>
    </tr> ";

// Fetch data from the database and append to the HTML table
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
        // <td><img src="./image/teacher/' . $row['personal_img'] . '" alt="Personal Image" style="max-width: 100px;"></td>
        <td>' . $row['personal_name'] . '</td>
        <td>' . $row['personal_education'] . '</td>
        <td>' . $row['personal_performace'] . '</td>
        </tr>';
}

$html .= "</table>";

// Write HTML content to PDF and output
$mpdf->WriteHTML($html);
$mpdf->Output();
?>
