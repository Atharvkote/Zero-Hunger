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
    $row = mysqli_fetch_assoc($request);  // Since Username is Unique

    $rank =  $row['rank'];

    // Fetch recent activity
    $activity_sql = "SELECT * FROM `recent-activity` WHERE username = '$username' ORDER BY activity_date DESC";
    $activity_request = mysqli_query($connection, $activity_sql);

    // Fetch user profile information
    $second_sql = "SELECT * FROM `users` WHERE username = '$username'";
    $second_sql_results = mysqli_query($connection, $second_sql);
    $row_2 = mysqli_fetch_assoc($second_sql_results);
    $name = $row_2['name'];
    $bio = $row_2['bio'];

    $isAdmin = false;
    $search = "SELECT * FROM `admins` WHERE username = '$username'";
    $request_rows = mysqli_query($connection, $search);
    $numRows = mysqli_num_rows($request_rows);
    if ($numRows != 0) {
        $isAdmin = true;
    }

    // Assign badges if not already assigned for this session
    include 'assignBadges.php'; // Ensure the assignBadges function is included
    assignBadges($row['username']); // Pass username to the function
    $_SESSION['badges_assigned'] = true; // Mark badges as assigned for this session

    // Fetch the first 3 badges based on username
    $badge_query = "SELECT * FROM user_badges JOIN badges ON user_badges.badge_id = badges.badge_id WHERE user_badges.username = ? LIMIT 3";
    $badge_stmt = $connection->prepare($badge_query);
    $badge_stmt->bind_param("s", $_SESSION['username']);
    $badge_stmt->execute();
    $badge_result = $badge_stmt->get_result();

    $query = "SELECT last_login_date, days_active FROM user_progress WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($last_login_date, $days_active);
    $stmt->fetch();
    $stmt->close();

    $today = date('Y-m-d');
    if ($last_login_date !== $today) {
        $days_active++;
        $updateQuery = "UPDATE user_progress SET days_active = days_active + 1, hunger_points = hunger_points + 1, last_login_date = ? WHERE username = ?";
        $stmt = $connection->prepare($updateQuery);
        $stmt->bind_param('si', $today, $username);
        $stmt->execute();
        $stmt->close();
    }


    function getUserProgress($username, $connection)
    {
        $hunger_points = 0;
        $donations_count = 0;
        $reports_count = 0;
        $days_active = 0;
        $query = "SELECT hunger_points, donations_count, reports_count, days_active FROM user_progress WHERE username = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($hunger_points, $donations_count, $reports_count, $days_active);
        $stmt->fetch();
        $stmt->close();
        return [
           'hunger_points' => $hunger_points ?? 0,
        'donations_count' => $donations_count ?? 0,
        'reports_count' => $reports_count ?? 0,
        'days_active' => $days_active ?? 0
        ];
    }

    $progress = getUserProgress($username, $connection);
    $connection->close();
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
                        echo '<img src="../../uploads/Default-Image.png" alt="default-img" height="100px" width="100px">';
                    } else {
                        $path = $row_2['profile_photo'];
                        echo '<div class="ppic"><img src="' . $path . '" height="100px" width="100px"></div>';
                    }
                    ?>
                </div>
                <div class="right-content">
                    <div class="name_H">
                        <h1><?php echo $_SESSION['username']; ?></h1>
                        <?php if ($isAdmin) {
                            echo '<div class="tick"><img src="../../images/Orange-Tick.png" alt="tick" height="35px" width="35px"></div>';
                        } ?>
                        <p id="name1">( <?php echo $name; ?> )</p>
                    </div>
                    <p> Rank : <?php echo $rank ?> </p>
                </div>
            </div>
            <!-- Add this new container for the bottom images -->
            <div class="middle">
                <div class="info">
                    <ul>
                        <!-- <li><strong>Email : </strong><?php echo $_SESSION['email']; ?></li> -->
                        <li><strong>State : </strong><?php echo $_SESSION['state']; ?></li>
                        <li><strong>District : </strong> <?php echo $_SESSION['district']; ?></li>
                        <li><strong>City : </strong> <?php echo $_SESSION['city']; ?></li>
                    </ul>
                </div>
                <div class="bottom-images">
                    <?php
                    if ($badge_result->num_rows > 0) {
                        $badge_count = 0;
                        while ($badge = $badge_result->fetch_assoc()) {
                            echo '<div class="badge">
                            <a href="myBadges.php"><img class="b" src="' . $badge['badge_image_path'] . '" alt="' . $badge['badge_name'] . '" height="100px" width="100px"></a> 
                            </div>';
                            $badge_count++;
                            if ($badge_count >= 3) break; // Only display the first 3 badges
                        }
                    } else {
                        echo '<div>';
                        echo '<a href="myBadges.php"><img class="no-badges" src="../../images/No-Bagde.png" alt="No badges earned" height="200px" width="200px"></a>';
                        echo '</div>';
                    }
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
                        <img src="../../images/No-Activity-Template.png" height="250px" width="250px">
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="badges-head">
        <h1><?php echo $username; ?>'s ZH Card</h1>
        <img src="../../images/Pre-Goal.png" alt="nilestonses" height="200px" width="200px">
        <img src="../../images/Discuss.png" alt="milestonses" height="200px" width="200px">
        <img src="../../images/1.png" alt="milestonses" height="200px" width="200px">
    </div>

    <div class="zh-card">
        <div class="progress-section">
            <div class="progress-ring ring_1" data-percentage="<?php echo $progress['hunger_points'] / 1000 * 100; ?>">
                <span class="progress-value p1"><?php echo $progress['hunger_points']; ?></span>
            </div>
            <p class="progress-title">Hunger Points</p>
            <p class="progress-count"><?php echo $progress['hunger_points']; ?> / 1000</p>
        </div>
        <div class="progress-section">
            <div class="progress-ring ring_2" data-percentage="<?php echo $progress['donations_count'] / 100 * 100; ?>">
                <span class="progress-value p2"><?php echo $progress['donations_count']; ?></span>
            </div>
            <p class="progress-title">Donations</p>
            <p class="progress-count"><?php echo $progress['donations_count']; ?> / 100</p>
        </div>
        <div class="progress-section">
            <div class="progress-ring ring_3" data-percentage="<?php echo $progress['reports_count'] / 100 * 100; ?>">
                <span class="progress-value p3"><?php echo $progress['reports_count']; ?></span>
            </div>
            <p class="progress-title">Reports</p>
            <p class="progress-count"><?php echo $progress['reports_count']; ?> / 100</p>
        </div>
        <div class="progress-section">
            <div class="progress-ring ring_4" data-percentage="<?php echo $progress['days_active'] / 100 * 100; ?>">
                <span class="progress-value p4"><?php echo $progress['days_active']; ?></span>
            </div>
            <p class="progress-title">Active Days</p>
            <p class="progress-count"><?php echo $progress['days_active']; ?> / 100</p>
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
    <script src="ProgressBar.js"></script>
</body>

</html>