<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการจัดการระบบค่าปรับคุณภาพถ่านหินย้อนหลัง (Lignite Purchase Agreement Invoice Management System)</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <div class="form-container" >
        <h1 style="font-size: 20px">รายงานการจัดการระบบค่าปรับคุณภาพถ่านหินย้อนหลัง (Lignite Purchase Agreement Invoice Management System)</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="year">ปี:</label>
            <select name="year" id="year" required>
                <option value="">เลือกปี</option>
                <?php
                $currentYear = date("Y");
                for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
                    echo "<option value=\"$i\">$i</option>";
                }
                ?>
            </select>
            
            <label for="month">เดือน:</label>
            <select name="month" id="month" required>
                <option value="">เลือกเดือน</option>
                <option value="มกราคม">มกราคม</option>
                <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                <option value="มีนาคม">มีนาคม</option>
                <option value="เมษายน">เมษายน</option>
                <option value="พฤษภาคม">พฤษภาคม</option>
                <option value="มิถุนายน">มิถุนายน</option>
                <option value="กรกฎาคม">กรกฎาคม</option>
                <option value="สิงหาคม">สิงหาคม</option>
                <option value="กันยายน">กันยายน</option>
                <option value="ตุลาคม">ตุลาคม</option>
                <option value="พฤศจิกายน">พฤศจิกายน</option>
                <option value="ธันวาคม">ธันวาคม</option>
            </select>
            
            <label for="pdf_file">อัพโหลดไฟล์ PDF:</label>
            <input type="file" name="pdf_file" id="pdf_file" accept=".pdf">
            
            <button type="submit" class="btn" style="background-color: #3CB371"><i class="fa fa-file-pdf-o"></i> Upload File</button><br><br>
        </form>


        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // กำหนดโฟลเดอร์อัพโหลดชั่วคราวและโฟลเดอร์สำรองข้อมูล
            $tempUploadDir = 'uploads/';
            $backupDir = 'BackupData/';
            
            // สร้างโฟลเดอร์หากยังไม่มี
            if (!file_exists($tempUploadDir)) {
                mkdir($tempUploadDir, 0777, true);
            }
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0777, true);
            }

            $month = isset($_POST['month']) ? $_POST['month'] : '';
            $year = isset($_POST['year']) ? $_POST['year'] : '';

            $newFileName = 'Invoice_' . $month . '_' . $year . '.pdf';
            
            // ตรวจสอบและจัดการการอัพโหลดไฟล์
            if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
                $tempUploadFile = $tempUploadDir . basename($_FILES['pdf_file']['name']);
                $backupFile = $backupDir . $newFileName;
                
                // ย้ายไฟล์จากโฟลเดอร์ชั่วคราวไปยังโฟลเดอร์สำรองข้อมูล
                if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $tempUploadFile)) {
                    // ย้ายไฟล์จากโฟลเดอร์อัพโหลดชั่วคราวไปยังโฟลเดอร์ BackupData พร้อมชื่อใหม่
                    if (rename($tempUploadFile, $backupFile)) {
                        echo "<h2 style=\"font-size: 16px;\">รายงานจัดการระบบค่าปรับคุณภาพถ่านหิน เดือน ". htmlspecialchars($_POST['month']) ." ปี ".htmlspecialchars($_POST['year'])."</h2>";
                        echo "
                        <div style=\"display: flex; justify-content: center; align-items: center; height: 55vh;\">
                            <iframe src=\"$backupFile\" width=\"600\" height=\"400\" style=\"border: 2px solid #000; border-radius: 10px;\" frameborder=\"0\"></iframe>
                        </div>";
                    } else {
                        echo "<p>เกิดข้อผิดพลาดในการย้ายไฟล์ไปยังโฟลเดอร์ BackupData</p>";
                    }
                } else {
                    echo "<p>เกิดข้อผิดพลาดในการอัพโหลดไฟล์</p>";
                }
            } else {
                echo "<p>โปรดอัพโหลดไฟล์ PDF</p>";
            }
        }
        ?>
    </div>
    <script>
        function submitForm(action) {
            var form = document.getElementById('mainForm');
            form.action = action;
            form.submit();
        }
    </script>
</body>


<div class="footer">
    แผนกวิเคราะห์และประเมินผลการทำเหมือง (หวป-ช.) เหมืองแม่เมาะ จังหวัดลำปาง
</div>
</html>
