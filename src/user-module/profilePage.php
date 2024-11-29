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

    $second_sql = "SELECT * FROM `users` WHERE username = '$username'";
    $second_sql_results = mysqli_query($connection, $second_sql);

    $row_2 = mysqli_fetch_assoc($second_sql_results);
    $name = $row_2['name'];
    $bio = $row_2['bio'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - Profile page</title>
    <link rel="stylesheet" href="profile-style.css">
    <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
</head>

<body>
    <?php
    include '../assets/navbar.php';  // Import navbar as a component 
    ?>
    <div class="main-container">
        <div class="left">
            <div class="content">
                <div class="left-content">
                    <?php
                    if (is_null($row_2['profile_photo'])) {
                        echo '<img src="../../uploads/Person-Logo.png" height="100px" width="100px">';
                    } else {
                        $path = $row_2['profile_photo'];
                        echo '<div class="ppic"><img src="' . $path . '" height="100px" width="100px"></div>';
                    }
                    ?>
                </div>
                <div class="right-content">
                    <div class="name_H">
                        <h1><?php echo $_SESSION['username']; ?></h1>
                        <p id="name1">( <?php echo $name; ?> )</p>
                    </div>
                    <p> Rank : <?php echo $rank ?> </p>
                </div>
            </div>
            <!-- Add this new container for the bottom images -->
            <div class="middle">
                <div class="info">
                    <ul>
                        <li><strong>Email : </strong><?php echo $_SESSION['email']; ?></li>
                        <li><strong>State : </strong><?php echo $_SESSION['state']; ?></li>
                        <li><strong>District : </strong> <?php echo $_SESSION['district']; ?></li>
                        <li><strong>City : </strong> <?php echo $_SESSION['city']; ?></li>
                    </ul>
                </div>
                <div class="bottom-images">
                    <?php
                    if ($rank == 'Newbie') {
                        echo '<div class="img-op"><img src="../../images/No-Bagde.png" height="200px" width="200px"></div>';
                    } // } else {
                    //     echo "hello";
                    // }
                    ?>
                </div>
            </div>
            <div class="bio">
                <h3>About <?php echo $_SESSION['username']; ?> :</h3>
                <p><?php echo $bio; ?></p>
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
                    $count = 0;
                    while ($activity_row = mysqli_fetch_assoc($activity_request)) {
                        if ($count >= 5) {
                            break; // Stop after 5 activities
                        }
                        echo '<button><b>' . htmlspecialchars($activity_row['activity_description']) . '</b><!--<img src="../../images/Black-Arrow.png" height="40px" width="30px">---></button>';
                        $count++;
                    }
                } else {
                    echo '<p class="no-activity">No recent activity to display.</p>'; // Message if no activities
                    echo '
            <div class="no-activity-img">
                  <img src="../../images/No-Activity-Template.png" height="250px" width="250px"> <!-- Corrected the closing quote for width -->
            </div>';
                }
                ?>
            </div>


        </div>
    </div>

<h3 class="hhh2">Settings and More</h3>

    <div class="container-option">
        <div class="group">
            <a href="editPorfile.php"><button><b>Edit Profile</b></button></a>
            <a href="../main-module/contactUs.php"><button><b>Report Issue</b></button></a>
            <a href="https://github.com/Atharvkote/Zero-Hunger.git"><button><b>Contribute to this Project</b></button></a>
            <a href="../login-module/logout.php"><button><b>Log Out</b></button></a>
            </div>
    </div>
</body>

</html>