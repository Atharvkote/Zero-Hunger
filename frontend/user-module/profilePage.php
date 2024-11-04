<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login-module/loginPage.php");
    exit();
} else {
    include '../assets/DataBase-LINK.php';
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `users-information` WHERE username = '$username'";
    $request = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($request);                        // since Username is Unique

    $rank =  $row['rank'];

    $activity_sql = "SELECT * FROM `recent-activity` WHERE username = '$username' ORDER BY activity_date DESC";
    $activity_request = mysqli_query($connection, $activity_sql);
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - Profile page</title>
    <link rel="stylesheet" href="profile-style.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">
</head>

<body>
    <?php
    include '../assets/navbar.php';  // Import navbar as a component 
    ?>
    <div class="main-container">
        <div class="left">
            <div class="content">
                <div class="left-content">
                    <img src="../../images/Person-Logo.png" height="100px" width="100px">
                </div>
                <div class="right-content">
                    <h1><?php echo $_SESSION['username']; ?></h1>
                    <p> Rank : <?php echo $rank ?> </p>
                </div>
            </div>
            <!-- Add this new container for the bottom images -->
            <div class="middle">
                <div class="info">
                    <ul>
                        <li><strong>Email :</strong><?php echo $_SESSION['email']; ?></li>
                        <li><strong>State :</strong><?php echo $_SESSION['state']; ?></li>
                        <li><strong>District :</strong> <?php echo $_SESSION['district']; ?></li>
                    </ul>
                </div>
                <div class="bottom-images">
                    <img src="../../images/1st-Medal.png" alt="image" height="50px" width="50px">
                    <img src="../../images/2nd-Medal.png" alt="image" height="50px" width="50px">
                    <img src="../../images/3rd-Medal.png" alt="image" height="50px" width="50px">
                </div>
            </div>
            <div class="bio">
                <h3>About <?php echo $_SESSION['username']; ?> :</h3>
                <p>Hey! I am <?php echo $_SESSION['username']; ?> from <?php echo $_SESSION['district']; ?>, <?php echo $_SESSION['state']; ?>, a proud Regular Donor at ZERO Hunger. Chasing that 1% that can change 99%.</p>
            </div>
        </div>

        <div class="right">
            <div class="right-text">
                <h3><?php echo $_SESSION['username']; ?>'s Recent Activity</h3>
            </div>
            <div class="button-group">
                <?php
                // Check if there are any activities
                if (mysqli_num_rows($activity_request) > 0) {
                    while ($activity_row = mysqli_fetch_assoc($activity_request)) {
                        echo '<button><b>' . htmlspecialchars($activity_row['activity_description']) . '</b><img src="../../images/Black-Arrow.png" height="40px" width="30px"></button>';
                    }
                } else {
                    echo '<p class="no-activity">No recent activity to display.</p>'; // Message if no activities
                    echo '
                        <div class="no-activiy-img">
                              <img src="../../images/No-Activity-Template.png" height="100px" width="100px"> <!-- Corrected the closing quote for width -->
                        </div>
                    ';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="more">
        <a href="userMenu.php"><button type="button">More</button></a>
    </div>
</body>

</html>
