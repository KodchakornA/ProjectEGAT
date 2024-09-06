<!DOCTYPE html>
<html lang="en">
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
            <div class="site-name">
                <h1>Lignite Purchase Agreement Invoice Management System</h1>
            </div>
        </header>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #003366;
            font-family: Arial, sans-serif;
        }
        .login-container {
            /* text-align: center; */
            background-color: #01579b; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }
        label {
            color: white;
        }
        input[type="text"], input[type="password"] {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #46b37a;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #3a9a65;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #ffc107;
            color: black;
            text-align: center;
            padding: 10px 0;
            font-size: 16px;
        }
        .login {
            display: flex;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 style="color: white; text-align: center;">Login</h2>
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo "<p style='color:#e84e40;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="LignitePurchaseConn.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input class="login" type="submit" value="Login">
        </form>
    </div>

    <div class="footer">
        แผนกวิเคราะห์และประเมินผลการทำเหมือง (หวป-ช.) เหมืองแม่เมาะ จังหวัดลำปาง
    </div>

</body>
</html>
