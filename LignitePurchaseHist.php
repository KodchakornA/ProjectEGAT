<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการจัดการระบบค่าปรับคุณภาพถ่านหินย้อนหลัง (Lignite Purchase Agreement Invoice Management System)</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
            padding: 20px;
        }

        .bt-container {
            width: 300px;
            height: 580px; /* Fixed height */
            padding-right: 10px;
            background-color: #f0f0f0; /* Background color */
            position: fixed;
            top: 100px;
            left: 60px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .iframe-container {
            width: 1000px;
            align-items: flex-end;
            margin-top: 35px;
            margin-bottom: 30px;
            margin-left: 500px;
        }

        .year-btn {
            display: block;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f06292;
            color: #ffffff;
            border: none;
            padding: 10px;
            width: 300px;
            text-align: left;
        }

        .month-container {
            display: none;
            margin-left: 20px;
        }

        .month-btn {
            display: block;
            margin-bottom: 5px;
            border-radius: 5px;
            background-color: #3498db;
            color: #ffffff;
            border: none;
            padding: 5px;
            width: 150px;
            text-align: left;
        }

        .iframe-container iframe {
            width: 900px;
            height: 600px;
            border: 2px solid #000;
            border-radius: 10px;
            margin-top: 40px;
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="EGAT.png" alt="Logo">
        </div>
        <div class="site-name" style="display: flex; align-items: center; justify-content: center; position: relative;">
            <h1 style="flex-grow: 1; text-align: center;">
                Lignite Purchase Agreement Invoice Management System
            </h1>
            <button type="button" class="btb" style="background-color:#e84e40; position: absolute; right: 0;" onclick="window.location.href='LignitePurchaseWeb.php';">ย้อนกลับ</button>
        </div>
    </header>

    <?php
        // ฟังก์ชันสำหรับดึงปีและเดือนจากชื่อไฟล์
        function extractYearMonth($filename) {
            $pattern = '/Invoice_(.*?)_(\d{4})\.pdf$/';
            if (preg_match($pattern, $filename, $matches)) {
                return ['month' => $matches[1], 'year' => $matches[2]];
            }
            return null;
        }

        // ดึงรายการไฟล์จากไดเรกทอรี BackupData
        $backupDir = 'BackupData/';
        $files = array_diff(scandir($backupDir), array('..', '.'));
        $yearMonthData = [];

        foreach ($files as $file) {
            $info = extractYearMonth($file);
            if ($info) {
                $yearMonthData[$info['year']][] = $info['month'];
            }
        }
    ?>

        <?php
        // Function to sort months chronologically
        function sortMonths($months) {
            $monthOrder = [
                'มกราคม' => 1,
                'กุมภาพันธ์' => 2,
                'มีนาคม' => 3,
                'เมษายน' => 4,
                'พฤษภาคม' => 5,
                'มิถุนายน' => 6,
                'กรกฎาคม' => 7,
                'สิงหาคม' => 8,
                'กันยายน' => 9,
                'ตุลาคม' => 10,
                'พฤศจิกายน' => 11,
                'ธันวาคม' => 12,
            ];

            usort($months, function($a, $b) use ($monthOrder) {
                return $monthOrder[$a] - $monthOrder[$b];
            });

            return $months;
        }
        ?>

        <div class="container">
            <div class="bt-container">
                <?php
                    echo '<div class="drill-down">';
                    foreach ($yearMonthData as $year => $months) {
                        $sortedMonths = sortMonths($months); // Sort months chronologically

                        echo "<button class=\"year-btn\" data-year=\"$year\">$year</button>";
                        echo "<div class=\"month-container\" id=\"months-$year\">";
                        foreach ($sortedMonths as $month) {
                            echo "<button class=\"month-btn\" onclick=\"openPDF('$year', '$month')\">$month</button>";
                        }
                        echo "</div>";
                    }
                    echo '</div>';
                ?>
            </div>

            <div class="iframe-container" id="iframe-container">
                <!-- Iframe will be inserted here -->
            </div>
        </div>


    <script>
        // JavaScript สำหรับการแสดงหรือซ่อนเดือน
        document.querySelectorAll('.year-btn').forEach(button => {
            button.addEventListener('click', function() {
                const year = this.getAttribute('data-year');
                const monthContainer = document.getElementById('months-' + year);
                monthContainer.style.display = monthContainer.style.display === 'block' ? 'none' : 'block';
            });
        });

        // ฟังก์ชันสำหรับเปิด PDF ใน iframe
        function openPDF(year, month) {
            const filePath = `BackupData/Invoice_${month}_${year}.pdf`;
            const iframeContainer = document.getElementById('iframe-container');
            iframeContainer.innerHTML = `
                <iframe src="${filePath}" frameborder="0"></iframe>
            `;
        }
    </script>

    <div class="footer">
        แผนกวิเคราะห์และประเมินผลการทำเหมือง (หวป-ช.) เหมืองแม่เมาะ จังหวัดลำปาง
    </div>
</body>
</html>