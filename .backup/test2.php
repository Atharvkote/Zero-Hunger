<?php
session_start();
include '../assets/DataBase-LINK.php'; // Include your database connection file

$showError = "";

// Fetch the donation details (including latitude and longitude)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Query to fetch donations and associated items by the user
    $sql = "SELECT d.id, d.landmark, d.day, d.message, d.latitude, d.longitude, 
                   di.item_name, di.quantity, di.is_fresh 
            FROM donations AS d 
            LEFT JOIN donated_items AS di ON d.id = di.donation_id 
            WHERE d.username = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any records exist
    $donations = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Group items by donation
            $donations[$row['id']]['details'] = [
                'landmark' => $row['landmark'],
                'day' => $row['day'],
                'message' => $row['message'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude']
            ];
            // Append each item to the corresponding donation
            $donations[$row['id']]['items'][] = [
                'item_name' => $row['item_name'],
                'quantity' => $row['quantity'],
                'is_fresh' => $row['is_fresh']
            ];
        }
    } else {
        $showError = "No donation records found.";
    }

    $stmt->close();
} else {
    $showError = "User not logged in.";
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zero Hunger - Latest</title>
    <link rel="stylesheet" href="donate-Food.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">
    <link rel="stylesheet" href="lastestPage.css">
</head>

<body>
    <?php include '../assets/navbar.php'; ?> <!-- Navbar -->

    <h2>Happening Right..</h2>
    <?php if ($showError): ?>
        <p class="error"><?= htmlspecialchars($showError); ?></p>
    <?php else: ?>
        <?php foreach ($donations as $donation_id => $donation): ?>
            <div class="lastest-container">
                <div class="donation-details">
                    <h3>Donation on <?= htmlspecialchars($donation['details']['day']); ?></h3>
                    <p><strong>Landmark:</strong> <?= htmlspecialchars($donation['details']['landmark']); ?></p>
                    <p><strong>Message:</strong> <?= htmlspecialchars($donation['details']['message']); ?></p>
                    <p><strong>Location:</strong> Latitude: <?= htmlspecialchars($donation['details']['latitude']); ?>, Longitude: <?= htmlspecialchars($donation['details']['longitude']); ?></p>

                    <h4>Donated Items:</h4>
                    <ul>
                        <?php foreach ($donation['items'] as $item): ?>
                            <li>
                                <strong>Item:</strong> <?= htmlspecialchars($item['item_name']); ?>, 
                                <strong>Quantity:</strong> <?= htmlspecialchars($item['quantity']); ?>, 
                                <strong>Freshly Made:</strong> <?= $item['is_fresh'] ? 'Yes' : 'No'; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- Map for each donation location -->
                <div id="map-<?= $donation_id; ?>" class="map" 
                     data-lat="<?= htmlspecialchars($donation['details']['latitude']); ?>" 
                     data-lng="<?= htmlspecialchars($donation['details']['longitude']); ?>">
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <script>
        // Ensure initMap is globally accessible
        window.initMap = function() {
            document.querySelectorAll('.map').forEach(mapDiv => {
                const latitude = parseFloat(mapDiv.dataset.lat);
                const longitude = parseFloat(mapDiv.dataset.lng);

                if (!isNaN(latitude) && !isNaN(longitude)) {
                    const location = { lat: latitude, lng: longitude };
                    
                    const map = new google.maps.Map(mapDiv, {
                        zoom: 15,
                        center: location
                    });

                    new google.maps.Marker({
                        position: location,
                        map: map,
                        title: 'Donation Location'
                    });
                }
            });
        };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC35nqLu6BlDAuzhexc1w2QRcDhRc3v0kc&callback=initMap" loading="lazy"></script>
</body>
</html>
