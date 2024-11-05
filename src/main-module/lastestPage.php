<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login-module/loginPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - Latest</title>
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">

</head>

<body>

</body>

</html>