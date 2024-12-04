<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login-module/loginPage.php");
    exit();
}
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
            'donation_id' => $row['id'],
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


$showError2 = "";

// Fetch hunger point details with associated media paths (if any)
$sql = "
SELECT 
    needs.id AS need_id, 
    needs.spot_type, 
    needs.number_of_people, 
    needs.urgent, 
    needs.username, 
    needs.email, 
    needs.created_at, 
    needs.latitude, 
    needs.longitude, 
    (SELECT file_path FROM `needs-media` WHERE needs.id = `needs-media`.need_id LIMIT 1) AS media_path
FROM needs
GROUP BY needs.id
";
$showError2 = "";

// Execute the query
$result = $connection->query($sql);

// Check if any records exist
$hungerPoints = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mediaPath = $row['media_path'] ?? '../../images/Image-Template.png'; // Default path if media_path is null

        $hungerPoints[] = [
            'id' => $row['need_id'],
            'spot_type' => $row['spot_type'],
            'number_of_people' => $row['number_of_people'],
            'urgent' => $row['urgent'],
            'username' => $row['username'],
            'email' => $row['email'],
            'created_at' => $row['created_at'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'media_path' => $mediaPath // Use default if media_path is null
        ];
    }
} else {
    $showError2 = "No hunger point records found.";
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

    <!-- Buttons to toggle sections -->
    <div class="toggle-buttons">
        <img src="../../images/1.png" alt="milestonses" height="150px" width="150px">
        <button id="donationsButton" onclick="showDonations()">Donations</button>
        <button id="hungerPointsButton" onclick="showHungerPoints()">Hunger Points</button>
        <a href="../functionality-module/deliverFood.php"><button>Deliver(be A Volunteer)</button></a>
        <img src="../../images/2.png" alt="milestonses" height="150px" width="150px">
        <img src="../../images/3.png" alt="milestonses" height="150px" width="150px">
    </div>

    <!-- Donations Section -->
    <div id="donationsSection">
        <?php if ($showError): ?>
            <p class="error"><?= htmlspecialchars($showError); ?></p>
        <?php else: ?>
            <?php foreach ($donations as $donation_id => $donation): ?>
                <div class="lastest-container">
                    <div class="donation-details">
                        <div class="head-id">
                            <h3 class="h3"><img src="../../images/Person-Logo.png" alt="image" height="30px" width="30px"> <?= htmlspecialchars($donation['details']['username']); ?></h3>
                            <span class="arrow"></span>
                            <span class="arrow"></span>
                            <span class="arrow"></span>
                            <span class="arrow"></span>
                            <p><strong>Donation Id :</strong> <?= htmlspecialchars($donation['details']['donation_id']); ?></p>
                        </div>
                        <p><strong>Landmark:</strong> <?= htmlspecialchars($donation['details']['landmark']); ?></p>
                        <p><strong>Message:</strong> <?= htmlspecialchars($donation['details']['message']); ?></p>

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
                                <?php $j = 1; ?>
                                <?php foreach ($donation['items'] as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($j); ?></td>
                                        <td><?= htmlspecialchars($item['item_name']); ?></td>
                                        <td><?= htmlspecialchars($item['quantity']); ?></td>
                                        <td><?= $item['is_fresh'] ? 'Yes' : 'No'; ?></td>
                                    </tr>
                                    <?php $j++; ?>
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
    </div>
<!-- Hunger Points Section -->
<div id="hungerPointsSection" style="display:none;">
    <?php if ($showError2): ?>
        <p class="error"><?= htmlspecialchars($showError2); ?></p>
    <?php else: ?>
        <?php foreach ($hungerPoints as $hungerPoint): ?>
            <div class="lastest-container">
                <div class="hungerPoint-details">
                    <div class="head-id">
                        <h3 class="h3">
                            <img src="../../images/Person-Logo.png" alt="image" height="30px" width="30px">
                            <?= htmlspecialchars($hungerPoint['username']); ?>
                        </h3>
                        <span class="arrow"></span><span class="arrow"></span><span class="arrow"></span><span class="arrow"></span>
                        <p><strong>Hungerpoint Id :</strong> <?= htmlspecialchars($hungerPoint['id']); ?></p>
                    </div>
                    <p><strong>Spot Type:</strong> <?= htmlspecialchars($hungerPoint['spot_type']); ?></p>
                    <p><strong>Food Needed for:</strong> <?= htmlspecialchars($hungerPoint['number_of_people']); ?> people</p>
                    <p><strong>Urgency:</strong> <?= $hungerPoint['urgent'] == 1 ? 'Urgent' : 'Normal'; ?></p>
                    <p><strong>Created At:</strong> <?= htmlspecialchars($hungerPoint['created_at']); ?></p>

                    <!-- Display image if available -->
                    <?php if (!empty($hungerPoint['media_path'])): ?>
                        <div class="media-container">
                            <h4>Hunger Point Media:</h4>
                            <div class="side">
                                <?php
                                $fileInfo = pathinfo($hungerPoint['media_path']);
                                $fileExtension = strtolower($fileInfo['extension']);
                                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                                    echo '<img src="' . htmlspecialchars($hungerPoint['media_path']) . '" alt="Hunger Point Image" />';
                                    echo '<pre>';
                                    echo ($hungerPoint['media_path'] == '../../images/Image-Template.png') ? 'No Image Available' : 'Image Uploaded By ' . $hungerPoint['username'];
                                    echo '</pre>';
                                } elseif (in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'])) {
                                    echo '<video class="rounded-video" width="200" height="125" controls>';
                                    echo '<source src="' . htmlspecialchars($hungerPoint['media_path']) . '" type="video/' . $fileExtension . '">';
                                    echo 'Your browser does not support the video tag.';
                                    echo '</video>';
                                    echo '<pre>Video Uploaded By ' . $hungerPoint['username'] . '</pre>';
                                } else {
                                    echo 'Unsupported media format.';
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Display location on the map -->
                <div class="map" id="map-<?= $hungerPoint['id']; ?>"
                     data-lat="<?= htmlspecialchars($hungerPoint['latitude']); ?>"
                     data-lng="<?= htmlspecialchars($hungerPoint['longitude']); ?>">
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Initialize each map
document.querySelectorAll('.map').forEach(mapDiv => {
    const latitude = parseFloat(mapDiv.dataset.lat);
    const longitude = parseFloat(mapDiv.dataset.lng);

    if (isNaN(latitude) || isNaN(longitude)) {
        mapDiv.innerHTML = '<p>Location data not available</p>';
        return;
    }

    // Initialize the map
    const map = L.map(mapDiv).setView([latitude, longitude], 15);

    // Add Satellite tiles
    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    }).addTo(map);

    // Add a marker
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup('<b>Donation Location</b><br>Latitude: ' + latitude + '<br>Longitude: ' + longitude)
        .openPopup();

    // Store the map instance for later use
    mapDiv._leaflet_map = map;

    // Ensure map resizes properly
    map.invalidateSize();

    // Listen for window resize
    window.addEventListener('resize', () => {
        map.invalidateSize();
    });
});

    // Functions to toggle between Donations and Hunger Points sections
    function showDonations() {
        document.getElementById('donationsSection').style.display = 'block';
        document.getElementById('hungerPointsSection').style.display = 'none';
        document.getElementById('donationsButton').classList.add('active');
        document.getElementById('hungerPointsButton').classList.remove('active');
    }

    function showHungerPoints() {
        document.getElementById('donationsSection').style.display = 'none';
        document.getElementById('hungerPointsSection').style.display = 'block';
        document.getElementById('hungerPointsButton').classList.add('active');
        document.getElementById('donationsButton').classList.remove('active');

        document.querySelectorAll('#hungerPointsSection .map').forEach(mapDiv => {
        const map = mapDiv._leaflet_map; // Retrieve the map instance
        if (map) {
            map.invalidateSize(); // Force the map to recalculate its size
        }
    });
    }

    // Set the default view to Donations
    showDonations();
</script>

</body>

</html>