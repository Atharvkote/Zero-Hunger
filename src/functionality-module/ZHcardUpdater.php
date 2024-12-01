<?php
// session_start();
// include '../assets/DataBase-LINK.php'; // Database connection

function updateAfterDonation($username, $donationValue)
{
    global $connection;
    // Check if user exists in `user_progress`
    $query = "SELECT * FROM user_progress WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, update hunger points and donation count
        $update = "UPDATE user_progress 
                   SET hunger_points = hunger_points + ?, 
                       donations_count = donations_count + 1 
                   WHERE username = ?";
        $stmt = $connection->prepare($update);
        $stmt->bind_param("is", $donationValue, $username);
        $stmt->execute();
    } else {
        // User doesn't exist, insert new user with donation details
        $insert = "INSERT INTO user_progress (username, hunger_points, donations_count, account_created_date)
                   VALUES (?, ?, 1, CURDATE())";
        $stmt = $connection->prepare($insert);
        $stmt->bind_param("si", $username, $donationValue);
        $stmt->execute();
    }
}

function updateAfterReport($username, $needValue)
{
    global $connection;
    // Database connection

    // Check if user exists in `user_progress`
    $query = "SELECT * FROM user_progress WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, update hunger points and report count
        $update = "UPDATE user_progress 
                   SET hunger_points = hunger_points + ?, 
                       reports_count = reports_count + 1 
                   WHERE username = ?";
        $stmt = $connection->prepare($update);
        $stmt->bind_param("is", $needValue, $username);
        $stmt->execute();
    } else {
        // User doesn't exist, insert new user with report details
        $insert = "INSERT INTO user_progress (username, hunger_points, reports_count, account_created_date)
                   VALUES (?, ?, 1, CURDATE())";
        $stmt = $connection->prepare($insert);
        $stmt->bind_param("si", $username, $needValue);
        $stmt->execute();
    }
}

function updateActiveDays($username)
{
    global $connection;
    // Database connection

    // Check if user exists in `user_progress`
    $query = "SELECT * FROM user_progress WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, update active days
        $user = $result->fetch_assoc();
        $lastLoginDate = $user['last_login_date'];
        $currentDate = date('Y-m-d');

        // Check if last login is not today
        if ($lastLoginDate != $currentDate) {
            $activeDaysUpdate = "UPDATE user_progress 
                                 SET days_active = days_active + 1, 
                                     last_login_date = CURDATE() 
                                 WHERE username = ?";
            $stmt = $connection->prepare($activeDaysUpdate);
            $stmt->bind_param("s", $username);
            $stmt->execute();
        }
    } else {
        // User doesn't exist, insert user with default values
        $insert = "INSERT INTO user_progress (username, hunger_points, donations_count, reports_count, days_active, account_created_date, last_login_date)
                   VALUES (?, 0, 0, 0, 0, CURDATE(), CURDATE())";
        $stmt = $connection->prepare($insert);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }
}

?>
