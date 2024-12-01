<?php
function assignBadges($username)
{
    // include '../assets/DataBase-LINK.php';
    global $connection;
    // Fetch user's donation and need stats
    $stats_query = "
        SELECT 
            (SELECT COUNT(*) FROM donations WHERE username = ?) AS total_donations,
            (SELECT COUNT(*) FROM needs WHERE username = ?) AS total_needs";
    $stmt = $connection->prepare($stats_query);
    $stmt->bind_param("ss", $username, $username); // Use "ss" for string parameters
    $stmt->execute();
    $result = $stmt->get_result();
    $user_stats = $result->fetch_assoc();

    $total_donations = $user_stats['total_donations'];
    $total_needs = $user_stats['total_needs'];

    // echo"Total Donations: $total_donations, Total Needs: $total_needs";

    // Fetch applicable badges for donations
    $badge_query_donations = "
    SELECT * 
    FROM badges 
    WHERE criteria_type = 'donations' AND criteria_value <= ?";
    $badge_stmt_donations = $connection->prepare($badge_query_donations);
    $badge_stmt_donations->bind_param("i", $total_donations); // Integer binding for donation count
    $badge_stmt_donations->execute();
    $badges_result_donations = $badge_stmt_donations->get_result();

    // Fetch applicable badges for needs
    $badge_query_needs = "
    SELECT * 
    FROM badges 
    WHERE criteria_type = 'reports' AND criteria_value <= ?";
    $badge_stmt_needs = $connection->prepare($badge_query_needs);
    $badge_stmt_needs->bind_param("i", $total_needs); // Integer binding for needs count
    $badge_stmt_needs->execute();
    $badges_result_needs = $badge_stmt_needs->get_result();

    // Assign badges for donations
    while ($badge = $badges_result_donations->fetch_assoc()) {
        // echo("Assigning donation badge: " . $badge['badge_name']);
        // Check if the user already has this badge
        $check_query = "SELECT * FROM user_badges WHERE username = ? AND badge_id = ?";
        $check_stmt = $connection->prepare($check_query);
        $check_stmt->bind_param("si", $username, $badge['badge_id']);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            // Assign badge to user
            $insert_query = "INSERT INTO user_badges (username, badge_id) VALUES (?, ?)";
            $insert_stmt = $connection->prepare($insert_query);
            $insert_stmt->bind_param("si", $username, $badge['badge_id']);
            $insert_stmt->execute();
            // echo("Badge assigned: " . $badge['badge_name']);
        }
    }

    // Assign badges for needs
    while ($badge = $badges_result_needs->fetch_assoc()) {
        // echo("Assigning needs badge: " . $badge['badge_name']);
        // Check if the user already has this badge
        $check_query = "SELECT * FROM user_badges WHERE username = ? AND badge_id = ?";
        $check_stmt = $connection->prepare($check_query);
        $check_stmt->bind_param("si", $username, $badge['badge_id']);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            // Assign badge to user
            $insert_query = "INSERT INTO user_badges (username, badge_id) VALUES (?, ?)";
            $insert_stmt = $connection->prepare($insert_query);
            $insert_stmt->bind_param("si", $username, $badge['badge_id']);
            $insert_stmt->execute();
            // echo("Badge assigned: " . $badge['badge_name']);
        }
    }
}

?>
