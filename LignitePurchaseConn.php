<?php
session_start();

$users = [
    'admin' => 'password123',
    'Coalxxxx' => 'Agreexxxx',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        unset($_SESSION['error']);
        header("Location: LignitePurchaseWeb.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password!";
        header("Location: LignitePurchaseLogin.php");
        exit();
    }
}
?>
