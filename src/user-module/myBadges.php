<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login-module/loginPage.php");
    exit();
} else {
    include '../assets/DataBase-LINK.php';
    $username = $_SESSION['username']; // Make sure the user_id is available in session

    // Fetch all badges for the user
    $badge_query = "SELECT * FROM user_badges JOIN badges ON user_badges.badge_id = badges.badge_id WHERE user_badges.username = ?";
    $badge_stmt = $connection->prepare($badge_query);
    $badge_stmt->bind_param("s", $username);
    $badge_stmt->execute();
    $badge_result = $badge_stmt->get_result();

    // Fetch all available badges (including ones not yet earned)
    $all_badges_query = "SELECT * FROM badges";
    $all_badges_result = $connection->query($all_badges_query);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - My Badges</title>
    <link rel="stylesheet" href="myBadges.css"> <!-- Add styles for badges page -->
</head>

<body>
    <?php include '../assets/navbar.php'; ?> <!-- Include your navbar -->
    <div class="badges-head">
        <h1>My Badges</h1>
        <img src="../../images/Final.png" alt="nilestonses" height="200px" width="200px">
        <img src="../../images/2.png" alt="milestonses" height="200px" width="200px">
        <img src="../../images/3.png" alt="milestonses" height="200px" width="200px">
    </div>
    <div class="badges-container">
        <?php
         $yes =false;
        if ($badge_result->num_rows > 0) {

            while ($badge = $badge_result->fetch_assoc()) {
                $issued_date = date("Y-m-d", strtotime($badge['awarded_at']));
                echo '<div class="badge">
                <h4>Issued On : ' . $issued_date . '</h4>
                <img src="' . $badge['badge_image_path'] . '" alt="' . $badge['badge_name'] . '" height="150px" width="175px">
                <p>' . htmlspecialchars($badge['badge_name']) . '</p></div>';
            }
        } else {
           $yes=true;
        }
        ?>
    </div>
    <?php 
        if($yes){
        echo '<a href="myBadges.php"><img class="danger_p" src="../../images/No-Bagde.png" alt="No badges earned" height="200px" width="200px"></a>';
        }
    ?>
    <div class="badges-head">
    <h2>Remaining Badges</h2>
        <img src="../../images/Final.png" alt="nilestonses" height="200px" width="200px">
        <img src="../../images/2.png" alt="milestonses" height="200px" width="200px">
        <img src="../../images/3.png" alt="milestonses" height="200px" width="200px">
    </div>
    
      <!-- Display remaining badges -->
      <div class="remaining-badges">
        <div class="badges-container">
            <?php
            // Display badges that haven't been earned
            if ($all_badges_result->num_rows > 0) {
                while ($all_badge = $all_badges_result->fetch_assoc()) {
                    // Check if the badge is not in the user's earned badges
                    $badge_name = $all_badge['badge_name'];
                    $earned_query = "SELECT * FROM user_badges WHERE username = ? AND badge_id = ?";
                    $earned_stmt = $connection->prepare($earned_query);
                    $earned_stmt->bind_param("si", $username, $all_badge['badge_id']);
                    $earned_stmt->execute();
                    $earned_result = $earned_stmt->get_result();

                    // If the badge is not earned yet, display it
                    if ($earned_result->num_rows == 0) {
                        echo '<div class="badge">
                                <h4>' . htmlspecialchars($badge_name) . '</h4>
                                <img class="blurrrr" src="' . $all_badge['badge_image_path'] . '" alt="' . $badge_name . '" height="175px" width="175px">
                                <p>Not Earned Yet</p>
                            </div>';
                    }
                }
            }
            ?>
        </div>

</body>

</html>