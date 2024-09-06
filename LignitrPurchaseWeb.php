<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การจัดการระบบค่าปรับคุณภาพถ่านหิน (Lignite Purchase Agreement Invoice Management System)</title>
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
            <button type="button" class="btb" style="background-color:#46b37a; color: #ffff; position: absolute; right: 190px;" onclick="window.location.href='LignitePurchaseBackup.php';">บันทึกข้อมูล</button>
            <button type="button" class="btb" style="background-color:#039be5; color: #ffff; position: absolute; right: 70px;" onclick="window.location.href='LignitePurchaseHist.php';">รายงานย้อนหลัง</button>
            <button type="button" class="btb" style="background-color:#f4511e; color: #ffff; position: absolute; right: 0;" onclick="window.location.href='LignitePurchaseLogout.php';">Logout</button>
        </div>
    </header>

    <div class="form-container">
        <form id="mainForm" action="LignitePerchaseReport.php" method="post">
        <h2>กรอกข้อมูลตามแผนปี</h2>
            <div class="form-group">
                <label for="year">ปี:</label>
                <select name="Year" id="year" required>
                    <?php
                    $currentYear = date("Y");
                    for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="month">เดือน:</label>
                <select name="month" id="month" required>
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
            </div>

            <div class="form-group">
                <label for="volume">ปริมาณถ่านตามแผนปี(ตัน):</label>
                <input type="text" name="volume" id="volume" placeholder="กรุณากรอกปริมาณ" required/>
            </div>

            <div class="form-group">
                <label for="HHV">ค่าความร้อน (HHV):</label>
                <input type="text" name="HHV" id="HHV" placeholder="กรุณากรอกค่าความร้อน" required/>
            </div>

            <div class="form-group">
                <label for="SUL">%S:</label>
                <input type="number" name="SUL" id="SUL" step="0.01" onblur="formatToTwoDecimal(this)" placeholder="กรุณากรอกค่า %S" required/>
            </div>

            <div class="form-group">
                <label for="Cao">%CaO (Free SO3):</label>
                <input type="number" name="Cao" id="Cao" step="0.01" onblur="formatToTwoDecimal(this)" placeholder="กรุณากรอกค่า %CaO" required/>
                <label for="Cao" style="color:red; font-size:12px;">**ยังไม่มีการนำค่า %CaO มาคำนวณ</label>
            </div>

            <div class="form-group">
                <label for="price">ราคาถ่านที่กำหนดโดย กกพ. (บาท/ตัน):</label>
                <input type="text" name="price" id="price" oninput="formatToTwoDecimal(this)" placeholder="กรุณากรอกราคาถ่าน" required/>
            </div>

            <div class="form-group">
                <label for="sd">วันที่เริ่มต้น:</label>
                <input type="date" name="sd" id="sd" required/>
            </div>

            <div class="form-group">
                <label for="ed">วันที่สิ้นสุด:</label>
                <input type="date" name="ed" id="ed" required/>
            </div>

            <div class="form-group">
                <label for="sign">หมายเหตุ:</label>
                <textarea id="sign" name="sign" rows="1" placeholder="หมายเหตุ"></textarea>
            </div>
            
            <h3 style="color:gray; font-size:12px; text-align: center">หมายเหตุ: การนำปริมาณถ่านที่ส่งมอบมาคำนวณราคาถ่านจะคำนวณเฉพาะเดือนธันวาคมเท่านั้น เนื่องจากในสัญญาระบุให้คิดเป็นรายปี </h3>

            <div class="button-container">
                <button type="button" class="btn" onclick="submitForm('LignitePurchaseReport.php')"><i class="fa fa-folder"></i> Export report</button><br><br>
                <button type="button" class="btn" onclick="submitForm('LignitePurchaseReport2.php')" style="margin-left: 10px;"><i class="fa fa-folder"></i> Export report (end of year)</button>
            </div>
        </form>
    </div>
    <script>
        function submitForm(action) {
            var form = document.getElementById('mainForm');
            form.action = action;
            form.submit();
        }
    </script>

    <div class="footer">
        แผนกวิเคราะห์และประเมินผลการทำเหมือง (หวป-ช.) เหมืองแม่เมาะ จังหวัดลำปาง
    </div>
    
</body>
</html>
