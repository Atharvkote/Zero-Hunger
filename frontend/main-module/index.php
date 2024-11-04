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
    <title>Zero Hunger</title>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" /> -->
    <link rel="stylesheet" href="index-style.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">
</head>

<body>
    <?php
    include '../assets/navbar.php';  // import navbar as a componenet 
    ?>
    <div class="content">
        <div class="box">
            <h2>Zero Hunger - Be the Change You Want</h2>
            <img alt="Zero Hunger Logo" height="150" src="../../images/Zero-Hunger-Logo.png" width="200" />
            <p>The Zero Hunger project is a social initiative aimed at reducing food waste and alleviating hunger by connecting those with surplus food to those in need. Designed as a user-friendly website, it acts as a bridge between donors, such as households, restaurants, and grocery stores with extra food, and individuals or organizations seeking food assistance.</p>
            <p>Donors can easily list their surplus food items, specifying details such as quantity, freshness, and any special instructions for storage or handling. Those in need, whether individuals facing food insecurity or community organizations, can browse available donations or submit specific requests.</p>
        </div>
        <div class="box right">
            <div class="right-text">
                <p> अन्नपूर्णे सदापूर्णे नित्यपूर्णे जगत्पोषे।<br>
                रक्षिणी संसारस्य सर्वस्य कुरु कुशलम्। </p>
            </div>
            <div class="button-group">
                <a href="../functionality-module/needFood.php"><button><b>Need Food</b></button></a>
                <a href="../functionality-module/donateFood.php"><button><b>Donate Food</b></button></a>
                <a href="../volunteer-module/volunteer.php"><button><b>Volunteer</b></button></a>
                <a href="../sponser-module/sponser.php"><button><b>Sponser Us</b></button></a>
            </div>
        </div>
    </div>
</div>
</body>

</html>