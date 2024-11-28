<?php
session_start();
include '../assets/DataBase-LINK.php'; // Include your database connection file

$showError = "";

// Fetch the donation details (including latitude and longitude)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Query to fetch donations and associated items by the user
    $sql = "SELECT d.id, d.landmark, d.day, d.message, d.latitude, d.longitude,
       d.item_name_1, d.qty_1, d.freshly_made_1,
       d.item_name_2, d.qty_2, d.freshly_made_2,
       d.item_name_3, d.qty_3, d.freshly_made_3
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
            if (isset($row['id'])) {
                for ($i = 1; $i <= 3; $i++) { // Only 3 items in the SQL query
                    $item_name = 'item_name_' . $i;
                    $qty = 'qty_' . $i;
                    $freshly_made = 'freshly_made_' . $i;

                    if (!empty($row[$item_name])) { // Check if item exists
                        $donations[$row['id']]['items'][] = [
                            'item_name' => $row[$item_name],
                            'quantity' => $row[$qty],
                            'is_fresh' => $row[$freshly_made] ? 'Yes' : 'No'
                        ];
                    }
                }
            }
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
    <link rel="stylesheet" href="test.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .map {
            height: 300px;
            width: 100%;
            max-width: 500px;
            margin: 10px auto;
            border-radius: 10px;
            border: 1px solid #ddd;

        }

        .lastest-container {
            display: flex;
            justify-content: space-evenly;
            flex-direction: row;
            padding: 0;
            background-color: #f5d8b5;
            margin: 30px 60px;
            border-radius: 20px;
        }

        .donation-details {
            margin: 0px 60px 0px 30px;
        }

        h2 {
            background-color: #f28c28;
            padding-left: 40px;
            color: #fff;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            margin: 0px 55% 0px 0px;
            text-align: center;
        }

        .donation-details h3 {
            margin: 10px 0px 10px 0px;
            margin-left: -29px;
            padding-left: 30px;
            padding-right: 20px;
            border-radius: 3px 20px 20px 0px;
            background-color: #f28c28;
        }
    </style>
</head>

<body>
    <?php include '../assets/navbar.php'; ?> <!-- Navbar -->

    <h2>Happening Right Now</h2>
    <?php if ($showError): ?>
        <p class="error"><?= htmlspecialchars($showError); ?></p>
    <?php else: ?>
        <?php foreach ($donations as $donation_id => $donation): ?>
            <div class="lastest-container">
                <div class="donation-details">
                    <h3>Donation was done on <?= htmlspecialchars($donation['details']['day']); ?></h3>
                    <p><strong>Landmark:</strong> <?= htmlspecialchars($donation['details']['landmark']); ?></p>
                    <p><strong>Message:</strong> <?= htmlspecialchars($donation['details']['message']); ?></p>
                    <!-- <p><strong>Location:</strong> Latitude: <?= htmlspecialchars($donation['details']['latitude']); ?>, Longitude: <?= htmlspecialchars($donation['details']['longitude']); ?></p> -->

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

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize each map
        document.querySelectorAll('.map').forEach(mapDiv => {
            const latitude = parseFloat(mapDiv.dataset.lat);
            const longitude = parseFloat(mapDiv.dataset.lng);

            if (!isNaN(latitude) && !isNaN(longitude)) {
                const map = L.map(mapDiv).setView([latitude, longitude], 15); // Center the map

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                // Add a marker at the specified location
                L.marker([latitude, longitude]).addTo(map)
                    .bindPopup('<b>Donation Location</b><br>Latitude: ' + latitude + '<br>Longitude: ' + longitude)
                    .openPopup();
            }
        });
    </script>
</body>

</html>