<?php
session_start();
include '../assets/DataBase-LINK.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];

        // Save latitude and longitude in the donations table
        $sql = "INSERT INTO donations (username, email, latitude, longitude) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssdd", $username, $email, $latitude, $longitude);
        $stmt->execute();
        $stmt->close();
    }
}
?>
