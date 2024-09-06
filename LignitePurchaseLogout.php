<?php
session_start();

// Destroy all session data
session_destroy();

// Redirect to login page or a confirmation page
header("Location: LignitePurchaseLogin.php"); // Change this to your login page
exit;
?>