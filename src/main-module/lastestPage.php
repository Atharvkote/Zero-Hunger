<?php
session_start();
include '../assets/DataBase-LINK.php'; // Include your database connection file

$showError = "";

// Fetch all donation details (including latitude and longitude)
$sql = "SELECT id,username, landmark, day, message, latitude, longitude, 
               item_name_1, qty_1, freshly_made_1, 
               item_name_2, qty_2, freshly_made_2, 
               item_name_3, qty_3, freshly_made_3 
        FROM donations";

$result = $connection->query($sql);

// Check if any records exist
$donations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Group items by donation
        $donations[$row['id']]['details'] = [
            'username' => $row['username'],
            'landmark' => $row['landmark'],
            'day' => $row['day'],
            'message' => $row['message'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude']
        ];
        // Append each item to the corresponding donation
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
} else {
    $showError = "No donation records found.";
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - Latest</title>
    <link rel="stylesheet" href="donate-Food.css">
    <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
    <link rel="stylesheet" href="lastestPage.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

</head>

<body>
    <?php include '../assets/navbar.php'; ?> <!-- Navbar -->

    <h2 id="heading">Happening Right Now</h2>
    <?php if ($showError): ?>
        <p class="error"><?= htmlspecialchars($showError); ?></p>
    <?php else: ?>
        <?php foreach ($donations as $donation_id => $donation): ?>
            <div class="lastest-container">
                <div class="donation-details">
                <h3 class="h3"><img src="../../images/Person-Logo.png" alt="image" height="30px" width="30px"> <?= htmlspecialchars($donation['details']['username']); ?></h3>
                    <p><strong>Landmark:</strong> <?= htmlspecialchars($donation['details']['landmark']); ?></p>
                    <p><strong>Message:</strong> <?= htmlspecialchars($donation['details']['message']); ?></p>
                    <!-- <p><strong>Location:</strong> Latitude: <?= htmlspecialchars($donation['details']['latitude']); ?>, Longitude: <?= htmlspecialchars($donation['details']['longitude']); ?></p> -->

                    <h4>Donated Items:</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Item no.</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Freshly Made</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php $j = 1;?>
                            <?php foreach ($donation['items'] as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($j); ?></td>
                                    <td><?= htmlspecialchars($item['item_name']); ?></td>
                                    <td><?= htmlspecialchars($item['quantity']); ?></td>
                                    <td><?= $item['is_fresh'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                        <?php $j++;?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h3>Donation was done on <?= htmlspecialchars($donation['details']['day']); ?></h3>
                </div>
                <!-- Map for each donation location -->
                <div class="map" id="map-<?= $donation_id; ?>" class="map"
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