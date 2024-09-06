<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> รายงานการจัดการระบบค่าปรับคุณภาพถ่านหิน (Lignite Purchase Agreement Invoice Management System)</title>
</head>
<body>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Year = htmlspecialchars($_POST['Year']);
        $month = htmlspecialchars($_POST['month']);
        $volume = htmlspecialchars($_POST['volume']);
        $HHV = htmlspecialchars($_POST['HHV']);
        $SUL = htmlspecialchars($_POST['SUL']);
        $Cao = htmlspecialchars($_POST['Cao']);
        $price = htmlspecialchars($_POST['price']);
        $start_date = htmlspecialchars($_POST['sd']);
        $end_date = htmlspecialchars($_POST['ed']);
    }
    ?>
</body>


<head>
    <!-- <h1 font-size: 36px >การจัดการระบบค่าปรับคุณภาพถ่านหิน (Management of Coal Quality Fine Payment System)</h1> -->
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <style>
        table {
            border-collapse: collapse;
            width: 1%;
            margin: 10px;
            float: center;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            font-family: 'TH Sarabun', sans-serif;
            font-weight: bold;
            font-size: 36px;
        }
        h2 {
            margin-top: 30px;
            clear: both;
        }
        .container {
            display: flex;
            justify-content: space-around;
        }
    </style>
    <h1>การจัดการระบบค่าปรับคุณภาพถ่านหิน (Lignite Purchase Agreement Invoice Management System)</h1>
</head>
<body>
<?php
set_time_limit(0);

$myServer = "xx.xxx.xx.xxx";     
$myUser_route = "xxxxxxx";
$myUser_coal = "xxxxx";
$myPass_Route = "xxxxxxx";
$myPass_coal = "xxxx";
$myDB_Route = "xxxxx"; 
$myDB_414 = "xxxxx";
$myDB_813 = "xxxxxx"; 

try {
    $start_date = $_POST["sd"];
    $end_date = $_POST["ed"];

    $conn_mmrp1 = new COM("ADODB.Connection") or die("Cannot start ADO");
    $connStr = "PROVIDER=SQLOLEDB;SERVER=".$myServer.";UID=".$myUser_route.";PWD=".$myPass_Route.";DATABASE=".$myDB_Route; 
    $conn_mmrp1->open($connStr);

    
    $sql_mmrp1 = "SELECT dDate, D_CoalL1, D_CoalL2, D_CoalL3, D_CoalL4, D_CoalL5 FROM VIEW_line15_dailyreport WHERE dDate BETWEEN '$start_date' 
                    AND '$end_date' ORDER BY dDate";
    $result_mmrp1 = $conn_mmrp1->Execute($sql_mmrp1);

    $conn_mmp1 = new COM("ADODB.Connection") or die("Cannot start ADO for MMP_1");
    $connStr1 = "PROVIDER=SQLOLEDB;SERVER=$myServer;UID=$myUser_coal;PWD=$myPass_coal;DATABASE=$myDB_414"; 
    $conn_mmp1->open($connStr1);

    $sql_mmp1 = "SELECT DATE, COAL, COAL4 FROM VIEW_Coal WHERE DATE BETWEEN '$start_date' AND '$end_date' ORDER BY DATE";
    $result_mmp1 = $conn_mmp1->Execute($sql_mmp1);
 
    $conn_mmp813 = new COM("ADODB.Connection") or die("Cannot start ADO for U08data");
    $connStr2 = "PROVIDER=SQLOLEDB;SERVER=$myServer;UID=$myUser_coal;PWD=$myPass_coal;DATABASE=$myDB_813"; 
    $conn_mmp813->open($connStr2);
 
    $sql_mmp813 = "SELECT Sdate, Coal8, Coal9, Coal10, Coal11, Coal12, Coal13 FROM GenCon813 WHERE Sdate BETWEEN '$start_date' AND '$end_date' ORDER BY Sdate";
    $result_mmp813 = $conn_mmp813->Execute($sql_mmp813);

} catch (Exception $e) {
    echo "<h4><b>ไม่สามารถติดต่อกับฐานข้อมูลของโรงไฟฟ้าแม่เมาะได้</b></h4>";
    echo "<br>";
    exit();
}

$dates = [];
$totalsByLine = ["D_CoalL1" => 0, "D_CoalL2" => 0, "D_CoalL3" => 0, "D_CoalL4" => 0, "D_CoalL5" => 0];
$grand_total = 0;
$totalCoalFeederSum = 0;

while (!$result_mmrp1->EOF) {
    $dateValue = $result_mmrp1->Fields["dDate"]->value;
    $dates[] = $dateValue;
    $result_mmrp1->MoveNext();
}

while (!$result_mmp1->EOF) {
    $dateValue = $result_mmp1->Fields["DATE"]->value;
    if (!in_array($dateValue, $dates)) {
        $dates2[] = $dateValue;
    }
    $result_mmp1->MoveNext();
}

while (!$result_mmp813->EOF) {
    $dateValue = $result_mmp813->Fields["Sdate"]->value;
    if (!in_array($dateValue, $dates)) {
        $dates3[] = $dateValue;
    }
    $result_mmp813->MoveNext();
}


?>

<br>
<br>
<br>

<div>
<table style="width: 500px ;font-size: 20px; background-color: #8CDEDF; text-align: center;" border="1">
<?php
$start_date_formatted = date('d/m/Y', strtotime($start_date));
$end_date_formatted = date('d/m/Y', strtotime($end_date));

echo "<tr>";
echo '<th onclick="printPage();">ข้อมูลวันที่ ' . htmlspecialchars($start_date_formatted) . ' - ' . htmlspecialchars($end_date_formatted) . '</th>';
echo "</tr>";
?>
</table>
</div>
<!-- ====================================================================================================================================================================================== -->

<!-- ====================================================================================================================================================================================== -->
<div class="container">  
    <div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- <h2>Route & Coal</h2> -->
            <table style="width: 800px" border="1">
                <thead>
                    <tr>
                        <th colspan="7" style="background-color: #46b37a ;height: 40px">น้ำหนักถ่านเครื่องชั่ง Route Start (ปี <?php echo $_POST['Year']?>)</th>
                        <th rowspan="2" style="width: 100px; background-color: #93e1a1" padding="40px">น้ำหนักถ่าน Coal Feeder</th>
                    </tr>
                    <tr>
                        <th style="background-color: #82e0aa">Date</th>
                        <th style="background-color: #82e0aa">Line 1</th>
                        <th style="background-color: #82e0aa">Line 2</th>
                        <th style="background-color: #82e0aa">Line 3</th>
                        <th style="background-color: #82e0aa">Line 4</th>
                        <th style="background-color: #82e0aa">Line 5</th>
                        <th style="background-color: #82e0aa">Total</th>
                        <!-- <th>Total Coal Feeder</th> -->
                    </tr>
                </thead>
        <?php
        foreach ($dates as $dateValue) {
            $timestamp = strtotime($dateValue);
            $formattedDate = date('d/m/Y', $timestamp); 
            echo "<tr>";
            echo "<td>" . htmlspecialchars($formattedDate) . "</td>";

            $total = 0; 
            $sql_mmrp1 = "SELECT D_CoalL1, D_CoalL2, D_CoalL3, D_CoalL4, D_CoalL5 FROM VIEW_line15_dailyreport WHERE dDate = '$dateValue'";
            $result_mmrp1 = $conn_mmrp1->Execute($sql_mmrp1);

            for ($i = 1; $i <= 5; $i++) {
                $line = "D_CoalL" . $i;
                $value = $result_mmrp1->Fields[$line]->value;
                echo "<td>" . number_format($value) . "</td>";

                if (!is_null($value)) {
                    $totalsByLine[$line] += $value;
                    $total += $value;
                }
            }
            echo "<td>" . number_format($total) . "</td>"; 

            $total_mmp1 = 0;
            $totalFeeder414 = ["COAL" => 0, "COAL4" => 0];

            $sql_mmp1 = "SELECT COAL, COAL4 FROM VIEW_Coal WHERE DATE = '$dateValue'";
            $result_mmp1 = $conn_mmp1->Execute($sql_mmp1);

            foreach (["COAL", "COAL4"] as $line) {
                $value_mmp1 = $result_mmp1->Fields[$line]->value;
                if (!is_null($value_mmp1)) {
                    $totalFeeder414[$line] += $value_mmp1;
                    $total_mmp1 += $value_mmp1;
                }
            }

            $total_mmp813 = 0;
            $totalFeeder813 = ["Coal8" => 0, "Coal9" => 0, "Coal10" => 0, "Coal11" => 0, "Coal12" => 0, "Coal13" => 0];

            $sql_mmp813 = "SELECT Coal8, Coal9, Coal10, Coal11, Coal12, Coal13 FROM GenCon813 WHERE Sdate = '$dateValue'";
            $result_mmp813 = $conn_mmp813->Execute($sql_mmp813);

            foreach (["Coal8", "Coal9", "Coal10", "Coal11", "Coal12", "Coal13"] as $line) {
                $value_mmp813 = $result_mmp813->Fields[$line]->value;
                if (!is_null($value_mmp813)) {
                    $totalFeeder813[$line] += $value_mmp813;
                    $total_mmp813 += $value_mmp813;
                }
            }

            $totalCoalFeeder = $total_mmp1 + $total_mmp813;
            echo "<td>" . number_format($totalCoalFeeder) . "</td>";
            echo "</tr>";
            $tt[]=$totalCoalFeeder;
            $grand_total += $total;
            $totalCoalFeederSum += $totalCoalFeeder;
        }

        // Add the totals row
        echo "<tr style='font-weight: bold;'>";
        echo "<td style='background-color: #e5e7e9;'>Total</td>";
        for ($i = 1; $i <= 5; $i++) {
            $line = "D_CoalL" . $i;
            echo "<td style='background-color: #e5e7e9;'>" . number_format($totalsByLine[$line]) . "</td>";
        }
        echo "<td style='background-color: #e5e7e9;'>" . number_format($grand_total) . "</td>";
        echo "<td style='background-color: #e5e7e9;'>" . number_format($totalCoalFeederSum) . "</td>";
        echo "</tr>";
        ?>
        </table>
    </div>

<!-- ====================================================================================================================================================================================== -->

<!-- condition Routestart -->

<?php
set_time_limit(0);

$myServer = "xx.xxx.xx.xxx";
$myUser = "xxxxxx";
$myPass = "xxxxxxx";
$myDB = "xxxxx";

try {
    $conn_mmrp1 = new COM("ADODB.Connection") or die("Cannot start ADO");
    $connStr = "PROVIDER=SQLOLEDB;SERVER=$myServer;UID=$myUser;PWD=$myPass;DATABASE=$myDB";
    $conn_mmrp1->open($connStr);
} catch (Exception $e) {
    echo "<h4><b>ไม่สามารถติดต่อกับฐานข้อมูลของโรงไฟฟ้าแม่เมาะได้</b></h4><br>";
    exit();
}

$start_date = $_POST["sd"];
$end_date = $_POST["ed"]; 

$sql_mmrp1 = "SELECT dDate, D_CoalL1, D_CoalL2, D_CoalL3, D_CoalL4, D_CoalL5 FROM VIEW_line15_dailyreport WHERE dDate BETWEEN '$start_date' AND '$end_date' ORDER BY dDate";
$result_mmrp1 = $conn_mmrp1->Execute($sql_mmrp1);

$servername = "xx.xxx.xx.xxx";
$username = "xxxxxx";
$password = "xxxxxx";
$database = "quality_report";

$conn_prox = new mysqli($servername, $username, $password, $database);
if ($conn_prox->connect_error) {
    die("Connection failed: " . $conn_prox->connect_error);
}

$sql_prox = "SELECT date_of_sampling, sample_description, as_sulphur_content, as_gross_calorific_value_kcal FROM proximate 
                WHERE date_of_sampling >= '$start_date' ORDER BY date_of_sampling";
$result_prox = $conn_prox->query($sql_prox);

$data_by_date = [];
if ($result_prox->num_rows > 0) {
    while ($row = $result_prox->fetch_assoc()) {
        $date = $row["date_of_sampling"];
        $dateObject = new DateTime($date);
        $formattedDate = $dateObject->format('d/m/Y');

        if (!isset($data_by_date[$formattedDate])) {
            // $data_by_date[$formattedDate] = ["sulphur" => [], "gcv" => []];
            $data_by_date[$formattedDate] = ["gcv" => []];
        }
        $data_by_date[$formattedDate]["gcv"][$row["sample_description"]] = $row["as_gross_calorific_value_kcal"];
    }
}
?>

<div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table style="width: 700px" border="1">
        <tr>
            <th style="width: 500px; background-color: #DEB887 ; height: 40px" rowspan="3">แผนปี <?php echo $_POST['Year']?></th>
            <th style="background-color: #DEB887">ปริมาณ(ตัน)</th>
            <th style="width: 200px; background-color: #DEB887">ค่าความร้อน(HHV)</th>
            <th style="background-color: #DEB887">%s</th>
            <th style="width: 300px; background-color: #DEB887">%CaO (Free SO3)</th>
            <th style="width: 300px; background-color: #DEB887">ราคาถ่าน (บาท/ตัน)</th>
        </tr>
        <tr>
            <td rowspan="2" style="background-color: #fcf3cf"><?php echo number_format($_POST['volume'])?></td>
            <td rowspan="2" style="background-color: #fcf3cf"><?php echo number_format($_POST['HHV'])?></td>
            <td rowspan="2" style="background-color: #fcf3cf"><?php echo $_POST['SUL']?></td>
            <td rowspan="2" style="background-color: #fcf3cf"><?php echo $_POST['Cao']?></td>
            <td rowspan="2" style="background-color: #fcf3cf"><?php echo $_POST['price']?></td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <table style="width: 700px" border="1">
        <thead>
            <tr>
                <th colspan="7"style="background-color: #f48fb1; height: 40px">น้ำหนักถ่านเครื่องชั่ง Route Start (ปี <?php echo $_POST['Year']?>)</th>
            </tr>
            <tr>
                <th style="background-color:#fadbe8">Date</th>
                <th style="background-color:#fadbe8">Line 1</th>
                <th style="background-color:#fadbe8">Line 2</th>
                <th style="background-color:#fadbe8">Line 3</th>
                <th style="background-color:#fadbe8">Line 4</th>
                <th style="background-color:#fadbe8">Line 5</th>
                <th style="background-color:#fadbe8">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalRoute_hhv = ["D_CoalL1" => 0, "D_CoalL2" => 0, "D_CoalL3" => 0, "D_CoalL4" => 0, "D_CoalL5" => 0];
                $grand_total_hhv =  0;
                $count_total_0 = 0;

                while (!$result_mmrp1->EOF) {
                    $dateValue = $result_mmrp1->Fields["dDate"]->value;
                    $timestamp = strtotime($dateValue);
                    $formattedDate = date('d/m/Y', $timestamp);

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($formattedDate) . "</td>";

                    $line1_2 = isset($data_by_date[$formattedDate]["gcv"]["Line 1,2 NS"]) ? $data_by_date[$formattedDate]["gcv"]["Line 1,2 NS"] : "0";
                    $line3 = isset($data_by_date[$formattedDate]["gcv"]["Line 3 NS"]) ? $data_by_date[$formattedDate]["gcv"]["Line 3 NS"] : "0";
                    $line4 = isset($data_by_date[$formattedDate]["gcv"]["Line 4 NS"]) ? $data_by_date[$formattedDate]["gcv"]["Line 4 NS"] : "0";
                    $line5 = isset($data_by_date[$formattedDate]["gcv"]["Line 5 NS"]) ? $data_by_date[$formattedDate]["gcv"]["Line 5 NS"] : "0";

                    $total_hhv = 0;
                    for ($i = 1; $i <= 5; $i++) {
                        $line = "D_CoalL" . $i;
                        $value = $result_mmrp1->Fields[$line]->value;

                        if (($i <= 2 && $line1_2 == 0) || ($i == 3 && $line3 == 0) || ($i == 4 && $line4 == 0) || ($i == 5 && $line5 == 0)) {
                            $value = 0;
                        } else {
                            $value = is_numeric($value) ? intval($value) : 0;
                        }

                        echo "<td>" . number_format($value) . "</td>";

                        $totalRoute_hhv[$line] += $value;
                        $total_hhv += $value;
                    }
                    echo "<td>" . number_format($total_hhv) . "</td>";
                    echo "</tr>";
                    
                    // Accumulate the grand total
                    $grand_total_hhv += $total_hhv;
                    $total_1_hhv[] = $total_hhv;
                    $result_mmrp1->MoveNext();
                }
                // Display column totals
                echo "<tr>";
                echo "<td style='background-color: #e5e7e9;'><b>Total</b></td>";
                for ($i = 1; $i <= 5; $i++) {
                    $line = "D_CoalL" . $i;
                    // Display the total for each column, formatted with commas
                    echo "<td style='background-color: #e5e7e9;'>"."<b>" . (isset($totalRoute_hhv[$line]) ? 
                                                number_format($totalRoute_hhv[$line]) : '0') ."<b>". "</td>";
                }
                // Display the grand total
                echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format($grand_total_hhv) . "</b>"."</td>";
                echo "</tr>";
                ?>
        </tbody>
    </table>
</div>


<!-- ====================================================================================================================================================================================== -->

<!-- ====================================================================================================================================================================================== -->

<!-- <h2>Calculate HHV</h2> -->

<?php
set_time_limit(0);

$myServer = "xx.xxx.xx.xxx";
$myUser = "xxxxxx";
$myPass = "xxxxxxx";
$myDB = "xxxxx"; 

try {
    $conn_mmrp1 = new COM ("ADODB.Connection") or die("Cannot start ADO");
    $connStr = "PROVIDER=SQLOLEDB;SERVER=".$myServer.";UID=".$myUser.";PWD=".$myPass.";DATABASE=".$myDB; 
    $conn_mmrp1->open($connStr); // Open the connection to the database
} catch (Exception $e) {
    echo "<h4><b>ไม่สามารถติดต่อกับฐานข้อมูลของโรงไฟฟ้าแม่เมาะได้</b></h4>";
    echo "<br>";
    exit();
}

$start_date = $_POST["sd"];
$end_date = $_POST["ed"]; 

$sql_mmrp1 = "SELECT dDate, D_CoalL1, D_CoalL2, D_CoalL3, D_CoalL4, D_CoalL5 FROM VIEW_line15_dailyreport WHERE dDate BETWEEN '$start_date' AND '$end_date' ORDER BY dDate";

$result_mmrp1 = $conn_mmrp1->Execute($sql_mmrp1);

// <!-- ====================================================================================================================================================================================== -->

$servername = "xx.xxx.xx.xxx";
$username = "xxxxxx";
$password = "xxxxxx";
$database = "quality_report";

// Create connection
$conn_prox = new mysqli($servername, $username, $password, $database);

if ($conn_prox->connect_error) {
    die("Connection failed: " . $conn_prox->connect_error);
}

$start_date = $_POST["sd"];
$end_date = $_POST["ed"]; 

// Fetch Sulphur Content and Gross Calorific Value (kcal)
$sql_prox = "SELECT date_of_sampling, sample_description, as_sulphur_content, as_gross_calorific_value_kcal FROM proximate 
                WHERE date_of_sampling BETWEEN '$start_date' AND '$end_date' ORDER BY date_of_sampling";
$result_prox = $conn_prox->query($sql_prox);

// Group data by date
$data_by_date = [];
if ($result_prox->num_rows > 0) {
    while($row = $result_prox->fetch_assoc()) {
        $date = $row["date_of_sampling"];
        $dateObject = new DateTime($date);
        $formattedDate = $dateObject->format('d/m/Y');

        if (!isset($data_by_date[$formattedDate])) {
            $data_by_date[$formattedDate] = [
                "sulphur" => [],
                "gcv" => []
            ];
        }
        $data_by_date[$formattedDate]["sulphur"][$row["sample_description"]] = $row["as_sulphur_content"];
        $data_by_date[$formattedDate]["gcv"][$row["sample_description"]] = $row["as_gross_calorific_value_kcal"];
    }
}

?> 

    <div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
        <table style="width: 700px" border="1">
            <thead>
                <tr>
                    <th colspan = "7" style="background-color: #c39bd3; height: 40px">คำนวณค่าความร้อน</th>
                </tr>
                <tr>
                    <th style="background-color: #d2b4de">Line 1,2</th>
                    <th style="background-color: #d2b4de">Line 3</th>
                    <th style="background-color: #d2b4de">Line 4</th>
                    <th style="background-color: #d2b4de">Line 5</th>
                    <th style="background-color: #d2b4de">Total</th>
                </tr>
            </thead>

            <?php
            // $totalRoute = ["D_CoalL1" => 0, "D_CoalL2" => 0, "D_CoalL3" => 0, "D_CoalL4" => 0, "D_CoalL5" => 0];
            $totalByLine_hhv = ["Line1_2" => 0, "Line3" => 0, "Line4" => 0, "Line5" => 0];
            $totalByRow_hhv = [];
            
            while (!$result_mmrp1->EOF) {
                $dateValue = $result_mmrp1->Fields["dDate"]->value;
                $timestamp = strtotime($dateValue);
                $formattedDate = date('d/m/Y', $timestamp);
            
                echo "<tr>";
            
                $line1_2 = isset($data_by_date[$formattedDate]["gcv"]["Line 1,2 NS"]) ? $data_by_date[$formattedDate]["gcv"]["Line 1,2 NS"] : 0;
                $line3 = isset($data_by_date[$formattedDate]["gcv"]["Line 3 NS"]) ? $data_by_date[$formattedDate]["gcv"]["Line 3 NS"] : 0;
                $line4 = isset($data_by_date[$formattedDate]["gcv"]["Line 4 NS"]) ? $data_by_date[$formattedDate]["gcv"]["Line 4 NS"] : 0;
                $line5 = isset($data_by_date[$formattedDate]["gcv"]["Line 5 NS"]) ? $data_by_date[$formattedDate]["gcv"]["Line 5 NS"] : 0;
            
                $line1_2 = is_numeric($line1_2) ? intval($line1_2) : 0;
                $line3 = is_numeric($line3) ? intval($line3) : 0;
                $line4 = is_numeric($line4) ? intval($line4) : 0;
                $line5 = is_numeric($line5) ? intval($line5) : 0;
            
                $totalRow_hhv = 0;
            
                for ($i = 1; $i <= 5; $i++) {
                    $line = "D_CoalL" . $i;
                    $value = $result_mmrp1->Fields[$line]->value;
            
                    if ($line == "D_CoalL1") {
                        $d1 = $result_mmrp1->Fields["D_CoalL1"]->value;
                    }
                    if ($line == "D_CoalL2") {
                        $d2 = $result_mmrp1->Fields["D_CoalL2"]->value;
                        $sum1_2 = $d1 + $d2;
                        $cal_hhv1_2 = $sum1_2 * $line1_2;
                        echo "<td>" . number_format($cal_hhv1_2) . "</td>";
                        $totalByLine_hhv["Line1_2"] += $cal_hhv1_2;
                        $totalRow_hhv += $cal_hhv1_2;
                    }
                    if ($line == "D_CoalL3") {
                        $d3 = $result_mmrp1->Fields["D_CoalL3"]->value;
                        $cal_hhv3 = $d3 * $line3;
                        echo "<td>" . number_format($cal_hhv3) . "</td>";
                        $totalByLine_hhv["Line3"] += $cal_hhv3;
                        $totalRow_hhv += $cal_hhv3;
                    }            
                    if ($line == "D_CoalL4") {
                        $d4 = $result_mmrp1->Fields["D_CoalL4"]->value;
                        $cal_hhv4 = $d4 * $line4;
                        echo "<td>" . number_format($cal_hhv4) . "</td>";
                        $totalByLine_hhv["Line4"] += $cal_hhv4;
                        $totalRow_hhv += $cal_hhv4;
                    }            
                    if ($line == "D_CoalL5") {
                        $d5 = $result_mmrp1->Fields["D_CoalL5"]->value;
                        $cal_hhv5 = $d5 * $line5;
                        echo "<td>" . number_format($cal_hhv5) . "</td>";
                        $totalByLine_hhv["Line5"] += $cal_hhv5;
                        $totalRow_hhv += $cal_hhv5;
                    }
                                
                    // $totalRoute[$line] += $value;
                }
            
                echo "<td>" . number_format($totalRow_hhv) . "</td>"; // Display total for current row
                $totalByRow_hhv[] = $totalRow_hhv;
                $total_2_hhv[] = $totalRow_hhv;
                echo "</tr>";
            
                $result_mmrp1->MoveNext();
            }
            
            // Display totals for each line
            foreach ($totalByLine_hhv as $lineTotal_hhv) {
                echo "<td style='background-color: #e5e7e9;'>" ."<b>". number_format($lineTotal_hhv) ."</b>"."</td>";
            }
            echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format(array_sum($totalByRow_hhv)) ."</b>". "</td>"; // Total for all rows
            echo "</tr>";
            ?>
            

        </table>
    </div>

<!-- ====================================================================================================================================================================================== -->

<?php
$servername = "xx.xxx.xx.xxx";
$username = "xxxxxx";
$password = "xxxxxx";
$database = "quality_report";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$start_date = $_POST["sd"];
$end_date = $_POST["ed"]; 

// Fetch Sulphur Content and Gross Calorific Value (kcal)
$sql_prox = "SELECT date_of_sampling, sample_description, as_sulphur_content, as_gross_calorific_value_kcal FROM proximate WHERE date_of_sampling BETWEEN '$start_date' AND '$end_date' ORDER BY date_of_sampling";
$result_prox = $conn->query($sql_prox);

// Group data by date
$data_by_date = [];
if ($result_prox->num_rows > 0) {
    while($row = $result_prox->fetch_assoc()) {
        $date = $row["date_of_sampling"];
        $dateObject = new DateTime($date);
        $formattedDate = $dateObject->format('d/m/Y');

        if (!isset($data_by_date[$formattedDate])) {
            $data_by_date[$formattedDate] = [
                // "sulphur" => [],
                "gcv" => []
            ];
        }
        // $data_by_date[$formattedDate]["sulphur"][$row["sample_description"]] = $row["as_sulphur_content"];
        $data_by_date[$formattedDate]["gcv"][$row["sample_description"]] = $row["as_gross_calorific_value_kcal"];
    }
}
?>


<!-- ====================================================================================================================================================================================== -->

    <!-- Gross Calorific Value (kcal) Table -->
    <div>
        <br>
        <br>
        <br>
    <table style="width: 1700px" border="1">
        <thead>
            <tr>
                <th colspan = "4" style="background-color: #c39bd3">คำนวณสูตรปรับค่าความร้อน</th>
            </tr>
        </thead>
                <tr>
                    <td style="text-align: left; background-color: #d2b4de">สูตรปรับราคาค่าความร้อน &nbsp  &nbsp = &nbsp  &nbsp ราคาถ่าน x (Heat Lab เฉลี่ยรายวัน - Heat แผนรายปี + 200) / Heat แผนรายปี</td>
                </tr>
                <tr>
                    <td style="text-align: left; background-color: #d2b4de">ปรับเมื่อราคาค่าความร้อนจากผลวิเคราะห์มีค่าเฉลี่ยมีค่าต่ำกว่าหรือสูงกว่าค่าความร้อนจากแผนรายปีเกิน &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp  &nbsp  &nbsp  &nbsp 200.00 kcal/kg</td>
                </tr>
                <tr>
                    <td style="text-align: left; background-color: #d2b4de">ค่าเฉลี่ยค่าความร้อนต่ำสุด &nbsp &nbsp &nbsp  &nbsp  &nbsp  &nbsp2,567 kcal/kg &nbsp  &nbsp  &nbsp &nbsp MM-T8-13 &nbsp   &nbsp  &nbsp &nbsp 2,500 &nbsp  &nbsp &nbsp  &nbsp 1,800 &nbsp  &nbsp  &nbsp &nbsp MM-T14 &nbsp  &nbsp &nbsp  &nbsp 2,750 &nbsp  &nbsp &nbsp  &nbsp 655.00</td>
                </tr>
    </table>
        <br>
        <br>
        <!-- <h2>Gross Calorific Value (kcal)</h2> -->
        <table style="width: 1700px" border="1">
        <thead>
            <tr>
                <th colspan = "5" style="width: 500px; background-color: #c39bd3; height: 40px">ผลวิเคราะห์ค่าความร้อนถ่านส่งโรงไฟฟ้า Lab เหมือง (ปี <?php echo $_POST['Year']?>)</th>
                <th colspan = "7" style="width: 1300px; background-color: #c39bd3; height: 40px">ปรับราคาค่าความร้อน</th>
            </tr>
            <tr>
                <th style="background-color: #d2b4de">Line 1,2</th>
                <th style="background-color: #d2b4de">Line 3</th>
                <th style="background-color: #d2b4de">Line 4</th>
                <th style="background-color: #d2b4de">Line 5</th>
                <th style="background-color: #d2b4de">เฉลี่ย</th>
                <th style="background-color: #d2b4de">ค่าความร้อนแผนรายปี</th>
                <th style="background-color: #d2b4de">ค่าความร้อนแผนรายปี -200</th>
                <th style="background-color: #d2b4de">ค่าความร้อนแผนรายปี +200</th>
                <th style="background-color: #d2b4de">ค่าเฉลี่ยค่าความร้อนต่ำสุด</th>
                <th style="background-color: #d2b4de">ผลต่าง</th>
                <th style="background-color: #d2b4de">ปรับราคา/ตัน</th>
                <th style="background-color: #d2b4de">มูลค่า (บาท)</th>
            </tr>
        </thead>
        <?php
        $count_hhv = count($total_1_hhv);
        $c = 0;
        $TotalRouteCoal = 0;
        $total_cost_hhv = 0 ;
        $day_count_hhv = 0;
        foreach ($data_by_date as $date => $data) {
            echo "<tr>";

            $line1_2 = isset($data["gcv"]["Line 1,2 NS"]) ? $data["gcv"]["Line 1,2 NS"] : "";
            $line3 = isset($data["gcv"]["Line 3 NS"]) ? $data["gcv"]["Line 3 NS"] : "";
            $line4 = isset($data["gcv"]["Line 4 NS"]) ? $data["gcv"]["Line 4 NS"] : "";
            $line5 = isset($data["gcv"]["Line 5 NS"]) ? $data["gcv"]["Line 5 NS"] : "";

            $line1_2 = is_numeric($line1_2) ? number_format($line1_2, 0) : $line1_2;
            $line3 = is_numeric($line3) ? number_format($line3, 0) : $line3;
            $line4 = is_numeric($line4) ? number_format($line4, 0) : $line4;
            $line5 = is_numeric($line5) ? number_format($line5, 0) : $line5;

            echo "<td><span style='color: blue;'>".$line1_2."</td>";
            echo "<td><span style='color: blue;'>".$line3."</td>";
            echo "<td><span style='color: blue;'>".$line4."</td>";
            echo "<td><span style='color: blue;'>".$line5."</td>";

            $average_hhv = ($total_1_hhv[$c] != 0) ? $total_2_hhv[$c] / $total_1_hhv[$c] : 0;
            echo "<td>" . (is_numeric($average_hhv) ? number_format($average_hhv) : $average_hhv) . "</td>";

            $hhv_plan = intval($_POST['HHV']);
            echo "<td>".number_format($hhv_plan)."</td>";

            $hhv_minus200 = intval($_POST['HHV'])-200;
            echo "<td>".number_format($hhv_minus200)."</td>";

            $hhv_plus200 = intval($_POST['HHV'])+200;
            echo "<td>".number_format($hhv_plus200)."</td>";

            $hhv_lowest = 2567;
            echo "<td>".number_format(2567)."</td>";

            if($average_hhv != 0){
                $diff_hhv = is_numeric($average_hhv) ? $average_hhv - $hhv_plan : 0;
                if ($diff_hhv > 200){
                    echo "<td><span style='color: red;'>" . (is_numeric($diff_hhv) ? number_format($diff_hhv,2) : $diff_hhv) . "</td>";
                    // $day_count_hhv++;
                } else{
                    echo "<td>" . (is_numeric($diff_hhv) ? number_format($diff_hhv,2) : $diff_hhv) . "</td>";
                }
            } else {
                echo '<td style="background-color: #cd6155;"></td>';
            }

            if($diff_hhv > 200 || $diff_hhv < -200){
                $day_count_hhv++;
            }
            
            $fine = 0;
            if($average_hhv < $hhv_lowest){
                if ($average_hhv == 0){
                    //$fine = "";
                    echo '<td style="background-color: #cd6155;"></td>';
                } else {
                    $fine = (-($_POST['price'])) / 2;
                    if($fine != 0){
                        echo "<td><span style='color: red;'>" . number_format($fine) . "</td>";
                    } else {
                        echo "<td>" . number_format($fine) . "</td>";
                    }
                }
            } elseif (abs($diff_hhv) < 200) {
                $fine = 0;
                if($fine != 0){
                    echo "<td><span style='color: red;'>" . number_format($fine,2) . "</td>";
                } else {
                    echo "<td>" . number_format($fine,2) . "</td>";
                }
            } elseif ($diff_hhv > 0) {
                $fine = (($average_hhv - $hhv_plan - 200) * (($_POST['price']))) / ($hhv_plan);
                if($fine != 0){
                    echo "<td><span style='color: red;'>" . number_format($fine,2) . "</td>";
                } else {
                    echo "<td>" . number_format($fine,2) . "</td>";
                }
            } elseif ($diff_hhv < 0) {
                $fine = (($average_hhv - $hhv_plan + 200)*($_POST['price']))/($hhv_plan);
                if($fine != 0){
                    echo "<td><span style='color: red;'>" . number_format($fine,2) . "</td>";
                } else {
                    echo "<td>" . number_format($fine,2) . "</td>";
                }
            }

        if ($average_hhv == 0){
            echo '<td style="background-color: #cd6155;"></td>';
        } else{
            $cost = $fine * $tt[$TotalRouteCoal];
            if ($cost != 0){
                echo "<td><span style='color: red;'>" . number_format($cost, 2) . "</td>";
            } else {
                echo "<td>" . number_format($cost, 2) . "</td>";
            }
            $total_cost_hhv += $cost;
        }
        $TotalRouteCoal += 1;

// print_r($fine);
        $c++;
        echo "</tr>";
        }
        echo "<tr>";

        $line1_2_Total_hhv = $totalRoute_hhv["D_CoalL1"] + $totalRoute_hhv["D_CoalL2"];
        if ($line1_2_Total_hhv != 0) {
            $avg_1_2_hhv = $totalByLine_hhv["Line1_2"] / $line1_2_Total_hhv;
            echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format($avg_1_2_hhv)."</b>" . "</td>";   
            } 

        if ($totalRoute_hhv["D_CoalL3"] != 0) {
            $avg_3_hhv = $totalByLine_hhv["Line3"] / $totalRoute_hhv["D_CoalL3"];
            $avg_3_hhv = number_format($avg_3_hhv);
        } else {
            $avg_3_hhv = '0';
        }
        
        echo "<td style='background-color: #e5e7e9;'><b>" . $avg_3_hhv . "</b></td>";
        

        if ($totalRoute_hhv["D_CoalL4"] != 0) {
            $avg_4_hhv = $totalByLine_hhv["Line4"] / $totalRoute_hhv["D_CoalL4"];
            echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format($avg_4_hhv) ."</b>". "</td>";
        }

        if ($totalRoute_hhv["D_CoalL5"] != 0) {
            $avg_5_hhv = $totalByLine_hhv["Line5"] / $totalRoute_hhv["D_CoalL5"];
            echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format($avg_5_hhv) ."</b>". "</td>";
        }

        $grand_average_hhv = ($grand_total_hhv != 0) ? number_format(array_sum($totalByRow_hhv) / $grand_total_hhv) : "N/A";
        echo "<td style='background-color: #e5e7e9;'>"."<b>".$grand_average_hhv."</b>"."</td>";
        echo "<td colspan='6' style='background-color: #e5e7e9;'><b>รวมค่าปรับราคา(บาท)</b></td>";
        echo "<td style='background-color: #e5e7e9;'>" ."<b>". number_format($total_cost_hhv, 2) ."</b>". "</td>";
        echo "</tr>";
        ?>

        </table>
    </div>
    
<!-- ====================================================================================================================================================================================== -->

<!-- condition Routestart -->

<?php
set_time_limit(0);

$myServer = "xx.xxx.xx.xxx";
$myUser = "xxxxxx";
$myPass = "xxxxxxx";
$myDB = "xxxxx"; 

try {
    $conn_mmrp1 = new COM("ADODB.Connection") or die("Cannot start ADO");
    $connStr = "PROVIDER=SQLOLEDB;SERVER=$myServer;UID=$myUser;PWD=$myPass;DATABASE=$myDB";
    $conn_mmrp1->open($connStr);
} catch (Exception $e) {
    echo "<h4><b>ไม่สามารถติดต่อกับฐานข้อมูลของโรงไฟฟ้าแม่เมาะได้</b></h4><br>";
    exit();
}

$start_date = $_POST["sd"];
$end_date = $_POST["ed"]; 

$sql_mmrp1 = "SELECT dDate, D_CoalL1, D_CoalL2, D_CoalL3, D_CoalL4, D_CoalL5 FROM VIEW_line15_dailyreport WHERE dDate BETWEEN '$start_date' AND '$end_date' ORDER BY dDate";
$result_mmrp1 = $conn_mmrp1->Execute($sql_mmrp1);

$servername = "xx.xxx.xx.xxx";
$username = "xxxxxx";
$password = "xxxxxx";
$database = "quality_report";

$conn_prox = new mysqli($servername, $username, $password, $database);
if ($conn_prox->connect_error) {
    die("Connection failed: " . $conn_prox->connect_error);
}

$sql_prox = "SELECT date_of_sampling, sample_description, as_sulphur_content, as_gross_calorific_value_kcal FROM proximate WHERE date_of_sampling >= '$start_date' ORDER BY date_of_sampling";
$result_prox = $conn_prox->query($sql_prox);

$data_by_date = [];
if ($result_prox->num_rows > 0) {
    while ($row = $result_prox->fetch_assoc()) {
        $date = $row["date_of_sampling"];
        $dateObject = new DateTime($date);
        $formattedDate = $dateObject->format('d/m/Y');

        if (!isset($data_by_date[$formattedDate])) {
            $data_by_date[$formattedDate] = ["sulphur" => []];
            // $data_by_date[$formattedDate] = ["gcv" => []];
        }
        $data_by_date[$formattedDate]["sulphur"][$row["sample_description"]] = $row["as_sulphur_content"];
        // $data_by_date[$formattedDate]["gcv"][$row["sample_description"]] = $row["as_gross_calorific_value_kcal"];
    }
}
?>

<div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table style="width: 700px" border="1">
        <thead>
            <tr>
                <th colspan="7" style="background-color: #f48fb1; height: 40px">น้ำหนักถ่านเครื่องชั่ง Route Start (ปี <?php echo $_POST['Year']?>)</th>
            </tr>
            <tr>
                <th style="background-color:#fadbe8">Date</th>
                <th style="background-color:#fadbe8">Line 1</th>
                <th style="background-color:#fadbe8">Line 2</th>
                <th style="background-color:#fadbe8">Line 3</th>
                <th style="background-color:#fadbe8">Line 4</th>
                <th style="background-color:#fadbe8">Line 5</th>
                <th style="background-color:#fadbe8">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalRoute_sul = ["D_CoalL1" => 0, "D_CoalL2" => 0, "D_CoalL3" => 0, "D_CoalL4" => 0, "D_CoalL5" => 0];
                $grand_total_sul =  0;

                while (!$result_mmrp1->EOF) {
                    $dateValue = $result_mmrp1->Fields["dDate"]->value;
                    $timestamp = strtotime($dateValue);
                    $formattedDate = date('d/m/Y', $timestamp);

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($formattedDate) . "</td>";

                    $line1_2 = isset($data_by_date[$formattedDate]["sulphur"]["Line 1,2 NS"]) ? $data_by_date[$formattedDate]["sulphur"]["Line 1,2 NS"] : "0";
                    $line3 = isset($data_by_date[$formattedDate]["sulphur"]["Line 3 NS"]) ? $data_by_date[$formattedDate]["sulphur"]["Line 3 NS"] : "0";
                    $line4 = isset($data_by_date[$formattedDate]["sulphur"]["Line 4 NS"]) ? $data_by_date[$formattedDate]["sulphur"]["Line 4 NS"] : "0";
                    $line5 = isset($data_by_date[$formattedDate]["sulphur"]["Line 5 NS"]) ? $data_by_date[$formattedDate]["sulphur"]["Line 5 NS"] : "0";

                    $total_sul = 0;
                    for ($i = 1; $i <= 5; $i++) {
                        $line = "D_CoalL" . $i;
                        $value = $result_mmrp1->Fields[$line]->value;

                        if (($i <= 2 && $line1_2 == 0) || ($i == 3 && $line3 == 0) || ($i == 4 && $line4 == 0) || ($i == 5 && $line5 == 0)) {
                            $value = 0;
                        } else {
                            $value = is_numeric($value) ? intval($value) : 0;
                        }

                        echo "<td>" . number_format($value) . "</td>";

                        $totalRoute_sul[$line] += $value;
                        $total_sul += $value;
                    }
                    echo "<td>" . number_format($total_sul) . "</td>";
                    echo "</tr>";
                    
                    // Accumulate the grand total
                    $grand_total_sul += $total_sul;
                    $total_1_sul[] = $total_sul;
                    $result_mmrp1->MoveNext();
                }
                // Display column totals
                echo "<tr>";
                echo "<td style='background-color: #e5e7e9;'><b>Total</b></td>";
                for ($i = 1; $i <= 5; $i++) {
                    $line = "D_CoalL" . $i;
                    // Display the total for each column, formatted with commas
                    echo "<td style='background-color: #e5e7e9;'>"."<b>" . (isset($totalRoute_sul[$line]) ? number_format($totalRoute_sul[$line]) : '0') ."<b>". "</td>";
                }
                // Display the grand total
                echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format($grand_total_sul) . "</b>"."</td>";
                echo "</tr>";
                ?>
        </tbody>
    </table>
</div>

<!-- ====================================================================================================================================================================================== -->

<!-- ====================================================================================================================================================================================== -->

<!-- <h2>Calculate Sulphur</h2> -->

<?php
set_time_limit(0);

$myServer = "xx.xxx.xx.xxx";
$myUser = "xxxxxx";
$myPass = "xxxxxxx";
$myDB = "xxxxx"; 

try {
    $conn_mmrp1 = new COM ("ADODB.Connection") or die("Cannot start ADO");
    $connStr = "PROVIDER=SQLOLEDB;SERVER=".$myServer.";UID=".$myUser.";PWD=".$myPass.";DATABASE=".$myDB; 
    $conn_mmrp1->open($connStr); // Open the connection to the database
} catch (Exception $e) {
    echo "<h4><b>ไม่สามารถติดต่อกับฐานข้อมูลของโรงไฟฟ้าแม่เมาะได้</b></h4>";
    echo "<br>";
    exit();
}

$start_date = $_POST["sd"];
$end_date = $_POST["ed"]; 

$sql_mmrp1 = "SELECT dDate, D_CoalL1, D_CoalL2, D_CoalL3, D_CoalL4, D_CoalL5 FROM VIEW_line15_dailyreport WHERE dDate BETWEEN '$start_date' AND '$end_date' ORDER BY dDate";

$result_mmrp1 = $conn_mmrp1->Execute($sql_mmrp1);

// <!-- ====================================================================================================================================================================================== -->

$servername = "xx.xxx.xx.xxx";
$username = "xxxxxx";
$password = "xxxxxx";
$database = "quality_report";

// Create connection
$conn_prox = new mysqli($servername, $username, $password, $database);

if ($conn_prox->connect_error) {
    die("Connection failed: " . $conn_prox->connect_error);
}

$start_date = $_POST["sd"];
$end_date = $_POST["ed"]; 

// Fetch Sulphur Content and Gross Calorific Value (kcal)
$sql_prox = "SELECT date_of_sampling, sample_description, as_sulphur_content, as_gross_calorific_value_kcal FROM proximate WHERE date_of_sampling BETWEEN '$start_date' AND '$end_date' ORDER BY date_of_sampling";
$result_prox = $conn_prox->query($sql_prox);

// Group data by date
$data_by_date = [];
if ($result_prox->num_rows > 0) {
    while($row = $result_prox->fetch_assoc()) {
        $date = $row["date_of_sampling"];
        $dateObject = new DateTime($date);
        $formattedDate = $dateObject->format('d/m/Y');

        if (!isset($data_by_date[$formattedDate])) {
            $data_by_date[$formattedDate] = [
                "sulphur" => [],
                "gcv" => []
            ];
        }
        $data_by_date[$formattedDate]["sulphur"][$row["sample_description"]] = $row["as_sulphur_content"];
        $data_by_date[$formattedDate]["gcv"][$row["sample_description"]] = $row["as_gross_calorific_value_kcal"];
    }
}

?> 

    <div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
        <table style="width: 500px" border="1">
            <thead>
                <tr>
                    <th colspan = "7" style="background-color: #5dade2; height: 40px">คำนวณค่ากำมะถัน</th>
                </tr>
                <tr>
                    <th style="background-color:#aed6f1">Line 1,2</th>
                    <th style="background-color:#aed6f1">Line 3</th>
                    <th style="background-color:#aed6f1">Line 4</th>
                    <th style="background-color:#aed6f1">Line 5</th>
                    <th style="background-color:#aed6f1">Total</th>
                </tr>
            </thead>

            <?php
            // $totalRoute = ["D_CoalL1" => 0, "D_CoalL2" => 0, "D_CoalL3" => 0, "D_CoalL4" => 0, "D_CoalL5" => 0];
            $totalByLine_sul = ["Line1_2" => 0, "Line3" => 0, "Line4" => 0, "Line5" => 0];
            $totalByRow_sul = [];
            
            while (!$result_mmrp1->EOF) {
                $dateValue = $result_mmrp1->Fields["dDate"]->value;
                $timestamp = strtotime($dateValue);
                $formattedDate = date('d/m/Y', $timestamp);
            
                echo "<tr>";
            
                $line1_2 = isset($data_by_date[$formattedDate]["sulphur"]["Line 1,2 NS"]) ? $data_by_date[$formattedDate]["sulphur"]["Line 1,2 NS"] : "0";
                $line3 = isset($data_by_date[$formattedDate]["sulphur"]["Line 3 NS"]) ? $data_by_date[$formattedDate]["sulphur"]["Line 3 NS"] : "0";
                $line4 = isset($data_by_date[$formattedDate]["sulphur"]["Line 4 NS"]) ? $data_by_date[$formattedDate]["sulphur"]["Line 4 NS"] : "0";
                $line5 = isset($data_by_date[$formattedDate]["sulphur"]["Line 5 NS"]) ? $data_by_date[$formattedDate]["sulphur"]["Line 5 NS"] : "0";
            
                $line1_2 = is_numeric($line1_2) ? floatval($line1_2) : 0;
                $line3 = is_numeric($line3) ? floatval($line3) : 0;
                $line4 = is_numeric($line4) ? floatval($line4) : 0;
                $line5 = is_numeric($line5) ? floatval($line5) : 0;
            
                $totalRow_sul = 0;
            
                for ($i = 1; $i <= 5; $i++) {
                    $line = "D_CoalL" . $i;
                    $value = $result_mmrp1->Fields[$line]->value;
            
                    if ($line == "D_CoalL1") {
                        $d1 = $result_mmrp1->Fields["D_CoalL1"]->value;
                    }
            
                    if ($line == "D_CoalL2") {
                        $d2 = $result_mmrp1->Fields["D_CoalL2"]->value;
                        $sum1_2 = $d1 + $d2;
                        $cal_sul_1_2 = $sum1_2 * $line1_2;
                        echo "<td>" . number_format($cal_sul_1_2) . "</td>";
                        $totalByLine_sul["Line1_2"] += $cal_sul_1_2;
                        $totalRow_sul += $cal_sul_1_2;
                    }
            
                    if ($line == "D_CoalL3") {
                        $d3 = $result_mmrp1->Fields["D_CoalL3"]->value;
                        $cal_sul3 = $d3 * $line3;
                        echo "<td>" . number_format($cal_sul3) . "</td>";
                        $totalByLine_sul["Line3"] += $cal_sul3;
                        $totalRow_sul += $cal_sul3;
                    }
            
                    if ($line == "D_CoalL4") {
                        $d4 = $result_mmrp1->Fields["D_CoalL4"]->value;
                        $cal_sul4 = $d4 * $line4;
                        echo "<td>" . number_format($cal_sul4) . "</td>";
                        $totalByLine_sul["Line4"] += $cal_sul4;
                        $totalRow_sul += $cal_sul4;
                    }
            
                    if ($line == "D_CoalL5") {
                        $d5 = $result_mmrp1->Fields["D_CoalL5"]->value;
                        $cal_sul5 = $d5 * $line5;
                        echo "<td>" . number_format($cal_sul5) . "</td>";
                        $totalByLine_sul["Line5"] += $cal_sul5;
                        $totalRow_sul += $cal_sul5;
                    }
            
                    // $totalRoute[$line] += $value;
                }
            
                echo "<td>" . number_format($totalRow_sul) . "</td>"; // Display total for current row
                $totalByRow_sul[] = $totalRow_sul;
                $total_2_sul[] = $totalRow_sul;
                echo "</tr>";
            
                $result_mmrp1->MoveNext();
            }
            
            // Display totals for each line
            foreach ($totalByLine_sul as $lineTotal_sul) {
                echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format($lineTotal_sul) ."</b>". "</td>";
            }
            echo "<td style='background-color: #e5e7e9;'>" ."<b>". number_format(array_sum($totalByRow_sul)) ."</b>". "</td>"; // Total for all rows
            echo "</tr>";
            ?>
            

        </table>
    </div>

<!-- ====================================================================================================================================================================================== -->

<!-- ====================================================================================================================================================================================== -->

    <!-- Sulphur Content Table -->
    <div>
        <br>
        <br>
        <br>
    <table style="width: 1400px" border="1">
        <thead>
            <tr>
                <th colspan = "5" style="background-color: #5dade2">คำนวณสูตรปรับค่ากำมะถัน</th>
            </tr>
        </thead>
                <tr>
                    <td style="text-align: left; background-color:#aed6f1">สูตรปรับราคาค่ากำมะถัน &nbsp  &nbsp = &nbsp  &nbsp 1% ราคาถ่าน x (%S Lab เฉลี่ยรายวัน - %S แผนรายปี - 0.3) / %S แผนรายปี</td>
                </tr>
                <tr>
                    <td style="text-align: left; background-color:#aed6f1"><br></td>
                </tr>
                <tr>
                    <td style="text-align: left; background-color:#aed6f1">ปรับเมื่อราคาค่ากำมะถันจากผลวิเคราะห์มีค่าเฉลี่ยมีค่าสูงกว่าค่ากำมะถันจากแผนรายปีเกิน &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp  &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp 0.3%</td>
                </tr>
    </table>
    <br>
    <br>
        <!--<h2>Sulphur Content</h2> -->
        <table style="width: 1400px" border="1">
            <thead
                <tr>
                    <th colspan = "5" style="width: 500px; background-color: #5dade2; height: 40px">ผลวิเคราะห์ค่ากำมะถันถ่านส่งโรงไฟฟ้า Lab เหมือง (ปี <?php echo $_POST['Year']?>)</th>
                    <th colspan = "6" style="width: 1000px; background-color: #5dade2; height: 40px">ปรับราคาค่ากำมะถัน</th>
                </tr>
                <tr>
                    <th style="background-color:#aed6f1">Line 1,2</th>
                    <th style="background-color:#aed6f1">Line 3</th>
                    <th style="background-color:#aed6f1">Line 4</th>
                    <th style="background-color:#aed6f1">Line 5</th>
                    <th style="background-color:#aed6f1">เฉลี่ย</th>
                    <th style="background-color:#aed6f1">ค่ากำมะถันแผนรายปี</th>
                    <th style="background-color:#aed6f1">ค่ากำมะถันแผนรายปี +0.3%</th>
                    <th style="background-color:#aed6f1">ค่ากำมะถันแผนรายปี -0.3%</th>
                    <th style="background-color:#aed6f1">ผลต่าง</th>
                    <th style="background-color:#aed6f1">ปรับราคา/ตัน</th>
                    <th style="background-color:#aed6f1">มูลค่า</th>
                </tr>
            </thead>
            <?php
            $count_sul = count($total_1_sul);
            $c = 0;
            $TotalRouteCoal = 0;
            $total_cost_sul = 0;
            $day_count_sul = 0;
            foreach ($data_by_date as $date => $data) {
                echo "<tr>";
                $line1_2 = isset($data["sulphur"]["Line 1,2 NS"]) ? $data["sulphur"]["Line 1,2 NS"] : "";
                $line3 = isset($data["sulphur"]["Line 3 NS"]) ? $data["sulphur"]["Line 3 NS"] : "";
                $line4 = isset($data["sulphur"]["Line 4 NS"]) ? $data["sulphur"]["Line 4 NS"] : "";
                $line5 = isset($data["sulphur"]["Line 5 NS"]) ? $data["sulphur"]["Line 5 NS"] : "";
                
                echo "<td><span style='color: blue;'>".$line1_2."</td>";
                echo "<td><span style='color: blue;'>".$line3."</td>";
                echo "<td><span style='color: blue;'>".$line4."</td>";
                echo "<td><span style='color: blue;'>".$line5."</td>";


                $average_sul = ($total_1_sul[$c] != 0) ? number_format(($total_2_sul[$c] / $total_1_sul[$c]),10) : 0;
                echo "<td>". (is_numeric($average_sul) ? number_format($average_sul,2) : $average_sul) ."</td>";

                $sul_plan = $_POST['SUL'];
                echo "<td>".number_format($sul_plan,2)."</td>";

                $sul_plus3 = ($_POST['SUL'])+0.3;
                echo "<td>".number_format($sul_plus3,2)."</td>";

                $sul_minus3 = ($_POST['SUL'])-0.3;
                echo "<td>".number_format($sul_minus3,2)."</td>";

                if ($average_sul != 0){
                    $diff_sul = is_numeric($average_sul) ? $average_sul - $sul_plan : 0;
                    if($diff_sul > 0.3){
                        echo "<td><span style='color: red;'>" . (is_numeric($diff_sul) ? number_format($diff_sul,2) : $diff_sul) . "</td>";
                    $day_count_sul++;
                    } else {
                        echo "<td>" . (is_numeric($diff_sul) ? number_format($diff_sul,2) : $diff_sul) . "</td>";
                    }
                } else {
                    echo '<td style="background-color: #cd6155;"></td>';
                }
                
                if ($average_sul != 0){
                    if($diff_sul > 0.3){
                        $fine_sul = (-($diff_sul-0.3))*(0.01*($_POST['price']))/$sul_plan;
                        echo "<td><span style='color: red;'>" . number_format($fine_sul,2) . "</td>";
                    } else {
                        $fine_sul = 0;
                        echo "<td>" . number_format($fine_sul,2) . "</td>";
                    }
                } else {
                    echo '<td style="background-color: #cd6155;"></td>';
                }
                
                if ($average_sul == 0){
                    echo '<td style="background-color: #cd6155;"></td>';
                } else {
                    $cost_sul = $fine_sul * $tt[$TotalRouteCoal];
                    if($cost_sul != 0){
                        echo "<td><span style='color: red;'>" . number_format($cost_sul, 2) . "</td>";
                    } else {
                        echo "<td>" . number_format($cost_sul, 2) . "</td>";
                    }
                    $total_cost_sul += $cost_sul;
                    // print_r($fine_sul);
                }
                $TotalRouteCoal += 1 ;

                $c++;
                echo "</tr>";
            }

            echo "<tr>";

            $line1_2_Total_sul = $totalRoute_sul["D_CoalL1"] + $totalRoute_sul["D_CoalL2"];
            if ($line1_2_Total_sul != 0) {
                $avg_1_2_sul = $totalByLine_sul["Line1_2"] / $line1_2_Total_sul;
                echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format($avg_1_2_sul,2)."</b>" . "</td>";   
                } 
            
            if ($totalRoute_sul["D_CoalL3"] != 0) {
                $avg_3_sul = $totalByLine_sul["Line3"] / $totalRoute_sul["D_CoalL3"];
                $avg_3_sul = number_format($avg_3_sul);
            } else {
                $avg_3_sul = '0';
            }
            echo "<td style='background-color: #e5e7e9;'><b>" . $avg_3_sul . "</b></td>";

            if ($totalRoute_sul["D_CoalL4"] != 0) {
                $avg_4_sul = $totalByLine_sul["Line4"] / $totalRoute_sul["D_CoalL4"];
                echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format($avg_4_sul,2) ."</b>". "</td>";
            }

            if ($totalRoute_sul["D_CoalL5"] != 0) {
                $avg_5_sul = $totalByLine_sul["Line5"] / $totalRoute_sul["D_CoalL5"];
                echo "<td style='background-color: #e5e7e9;'>"."<b>" . number_format($avg_5_sul,2) ."</b>". "</td>";
            }

            $grand_average_sul = ($grand_total_sul != 0) ? number_format((array_sum($totalByRow_sul) / $grand_total_sul),2) : "N/A";
            echo "<td style='background-color: #e5e7e9;'>"."<b>".$grand_average_sul."</b>"."</td>";
            echo "<td colspan='5' style='background-color: #e5e7e9;'><b>รวมค่าปรับราคา(บาท)</b></td>";
            echo "<td style='background-color: #e5e7e9;'>" ."<b>". number_format($total_cost_sul, 2) ."</b>". "</td>";
            
            echo "</tr>";
            ?>

        </table>
    </div>
</div>
<!-- ====================================================================================================================================================================================== -->
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div>
<?php
        foreach ($dates as $YearValue) {
            $timestamp = strtotime($YearValue);
            $formattedDate = date('Y', $timestamp); 
                
            $total_mmp1 = 0;
            $totalFeeder414 = ["COAL" => 0, "COAL4" => 0];
            $total_mmp813 = 0;
            $totalFeeder813 = ["Coal8" => 0, "Coal9" => 0, "Coal10" => 0, "Coal11" => 0, "Coal12" => 0, "Coal13" => 0];
                
            $yearValue = filter_var($formattedDate, FILTER_VALIDATE_INT); 
                
            if ($yearValue) {
                $sql_mmp1 = "SELECT COAL, COAL4 FROM VIEW_Coal WHERE YEAR(DATE) = $yearValue";
                $result_mmp1 = $conn_mmp1->Execute($sql_mmp1);
                
                if (!$result_mmp1->EOF) {
                    while (!$result_mmp1->EOF) {
                        foreach (["COAL", "COAL4"] as $line) {
                            $value_mmp1 = $result_mmp1->Fields[$line]->value;
                            if (!is_null($value_mmp1)) {
                                $totalFeeder414[$line] += $value_mmp1;
                                $total_mmp1 += $value_mmp1;
                            }
                        }
                        $result_mmp1->MoveNext();
                    }
                }
                
                $sql_mmp813 = "SELECT Coal8, Coal9, Coal10, Coal11, Coal12, Coal13 FROM GenCon813 WHERE YEAR(Sdate) = '$yearValue'";
                $result_mmp813 = $conn_mmp813->Execute($sql_mmp813);
                
                if (!$result_mmp813->EOF) {
                    while (!$result_mmp813->EOF) {
                        foreach (["Coal8", "Coal9", "Coal10", "Coal11", "Coal12", "Coal13"] as $line) {
                            $value_mmp813 = $result_mmp813->Fields[$line]->value;
                            if (!is_null($value_mmp813)) {
                                $totalFeeder813[$line] += $value_mmp813;
                                $total_mmp813 += $value_mmp813;
                            }
                        }
                        $result_mmp813->MoveNext();
                    }
                }
                
                $sumYear = $total_mmp1 + $total_mmp813;
            }
        }

        $volume = intval($_POST['volume']); 

        if ($volume > 0) {
            $year_plan = ($sumYear / $volume)* 100;
        } 
        $year_plan = number_format($year_plan)."%";
        // print_r($sumYear);
        // Final total sum for all years
        // echo "Total Sum for All Years: $TotalsumYear";
        ?>
        <?php
        if ($year_plan > 0.9) {
            $fine_volume = 0;
        } else{
            $fine_volume = abs($sumYear-number_format(intval($_POST['volume'])*(1-(10/100))))*0.1*$_POST['price'];
        }
        ?>
</div>

<br>
<br>
<br>
<br>

<div>
    <div>
    <table style="width: 1200px; font-size: 25px;" border="1">
                <thead>
                    <tr>
                        <th colspan="7" style="background-color: #87CEEB ;height: 40px">สรุป เดือน <?php echo $_POST['month'] . " " .$_POST['Year']?></th>
                    </tr>
                <thesd>
                    <tr>
                        <th style="text-align: left; background-color: #ddf2f4; height: 40px">ปรับราคาจากค่าความร้อน (<?php echo $day_count_hhv ?> วัน)</th>
                        <td style="text-align: right; background-color: #ddf2f4"><?php echo number_format($total_cost_hhv, 2);?></td>
                        <td style="text-align: right; width: 90px ; background-color: #ddf2f4">บาท</td>
                    </tr>
                    <tr>
                        <th style="text-align: left; background-color: #ddf2f4; height: 40px">ปรับราคาจากค่ากำมะถัน (<?php echo $day_count_sul ?> วัน)</th>
                        <td style="text-align: right; background-color: #ddf2f4"><?php echo number_format($total_cost_sul, 2);?></td>
                        <td style="text-align: right; background-color: #ddf2f4">บาท</td>
                    </tr>
                    <tr>
                        <th style="text-align: left; background-color: #ddf2f4; height: 40px">ปรับราคาจากปริมาณ</th>
                        <td style="text-align: right; background-color: #ddf2f4"><?php echo number_format($fine_volume,2);?></td>
                        <td style="text-align: right; background-color: #ddf2f4">บาท</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: left; background-color: #ddf2f4; font-size: 20px; color: red;">
                            <strong>*หมายเหตุ:</strong> ค่าปรับราคาจากปริมาณคิดเฉพาะเดือนธันวาคมเท่านั้น
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: left; background-color: #ddf2f4; height: 40px">รวมปรับราคา </th>
                        <td style="text-align: right; background-color: #ddf2f4"><?php echo number_format($total_cost_sul+$total_cost_hhv+0, 2);?></td>
                        <td style="text-align: right; background-color: #ddf2f4">บาท</td>
                    </tr>
                    <tr>
                        <th style="text-align: left; background-color: #ddf2f4; height: 40px">มูลค่าถ่านส่งโรงไฟฟ้าทั้งหมด </th>
                        <td style="text-align: right; background-color: #ddf2f4"><?php echo number_format(($totalCoalFeederSum*820)+($total_cost_sul+$total_cost_hhv+0), 2);?></td>
                        <td style="text-align: right; background-color: #ddf2f4">บาท</td>
                    </tr>
                    <tr>
                        <th style="text-align: left; background-color: #ffe082; height: 40px">คิดเป็นราคาถ่าน</th>
                        <td style="text-align: right; background-color: #ffe082"><?php echo number_format((($totalCoalFeederSum*820)+($total_cost_sul+$total_cost_hhv+0))/($totalCoalFeederSum), 2);?></td>
                        <td style="text-align: right; background-color: #ffe082">บาท/ตัน</td>
                    </tr>
                    <?php
                    $priceCoal = ((($totalCoalFeederSum*820)+($total_cost_sul+$total_cost_hhv+0))/($totalCoalFeederSum))-820;
                    if ($priceCoal < 0){
                        $pp = "ราคาถ่านลดลง =";
                    } else {
                        $pp = "ราคาถ่านเพิ่มขึ้น =";
                    }
                    ?>
                    <tr>
                        <th style="text-align: left; background-color: #FFB6C1; height: 40px"><?php echo $pp ?></th>
                        <td style="text-align: right; background-color: #FFB6C1"><?php echo number_format($priceCoal, 2);?></td>
                        <td style="text-align: right; background-color: #FFB6C1">บาท/ตัน</td>
                    </tr>
            </tbody>
        </table>
    </div>

<br>
<br>
<br>
<br>
<br>   

<div>
<body>
    <?php
        foreach ($dates as $dateValue) {
        $timestamp = strtotime($dateValue);
        $formattedDate = date('d/m/Y', $timestamp); 
        echo "<tr>";

        $total = 0; 
        $allValuesZero = true;
        $sql_mmrp1 = "SELECT D_CoalL1, D_CoalL2, D_CoalL3, D_CoalL4, D_CoalL5 FROM VIEW_line15_dailyreport WHERE dDate = '$dateValue'";
        $result_mmrp1 = $conn_mmrp1->Execute($sql_mmrp1);

        for ($i = 1; $i <= 5; $i++) {
            $line = "D_CoalL" . $i;
            $value = $result_mmrp1->Fields[$line]->value;

            if (!is_null($value)) {
                $totalsByLine[$line] += $value;
                $total += $value;

                if ($value != 0) {
                    $allValuesZero = false;
                }
            }
        }

        if ($allValuesZero) {
            if ($count_total_0 > 1) {
                if (!is_array($formattedDate)) {
                    $formattedDate = [$formattedDate];
                }
                $datesString = implode(', ', array_map('htmlspecialchars', $formattedDate));
                echo "<div colspan='8' style='font-size: 24px; color: #CC0000;'>หมายเหตุ : ข้อมูลวันที่ " . $datesString . " ไม่มีผลวิเคราะห์จาก Route Start จึงไม่มีการนำมาคิดคำนวณ</div>";
            } else {
                echo "<div colspan='8' style='font-size: 24px; color: #CC0000;'>หมายเหตุ : ข้อมูลวันที่ " . htmlspecialchars($formattedDate) . " ไม่มีผลวิเคราะห์จาก Route Start จึงไม่มีการนำมาคิดคำนวณ</div>";
            }
        }
    }
    ?>

    <br>
    <br>

    <?php
    if(!empty($_POST['sign'])){
        echo '<div style="font-size: 24px; text-align: left; color: #CC0000;">หมายเหตุ : ' . $_POST['sign'] . '</div>';
    } else {
        echo '<div style="font-size: 24px; text-align: left; color: #CC0000;">หมายเหตุ : -</div>';
    }
    ?>
</body>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>   



<?php
$start_time = microtime(true);

for ($i = 0; $i < 1000000; $i++) {
    $j = $i * $i;
}

$end_time = microtime(true);

$duration = $end_time - $start_time;


echo "ใช้เวลาประมวลผลทั้งหมด: " . number_format($duration, 6) . " seconds";
?>


</div>
<!-- ====================================================================================================================================================================================== -->

<?php
$conn_mmrp1->Close();
$conn_mmp1->Close();
$conn_mmp813->Close();
?>
</body>
</html>

<script type="text/javascript">

function printPage() {
    window.print();
}
</script>
