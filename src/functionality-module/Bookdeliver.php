<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_delivery'])) {
    include '../assets/DataBase-LINK.php';
    $donation_id = $_POST['F_D_Id'] ?? null;
    $hunger_point_id = $_POST['F_H_Id'] ?? null;
    $expected_delivery_date = $_POST['expected_date'] ?? null;
    $delivered_by = $_SESSION['username']; // Assuming the logged-in user's username

    if ($donation_id && $hunger_point_id && $expected_delivery_date) {
        $insert_delivery_query = "INSERT INTO deliveries (donation_id, hunger_point_id, expected_delivery_date, delivered_by) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($insert_delivery_query);
        $stmt->bind_param('iiss', $donation_id, $hunger_point_id, $expected_delivery_date, $delivered_by);

        if ($stmt->execute()) {
            $success_message = "Delivery successfully logged! Thank you for your contribution.";
            header("Location: deliverFood.php");
            exit();
        } else {
            $error_message = "Failed to log the delivery. Please try again.";
        }

        $stmt->close();
    } else {
        $error_message = "All fields, including the expected delivery date, are required.";
    }
}
?>
