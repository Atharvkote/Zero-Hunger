<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login-module/loginPage.php");
    exit();
}
include '../assets/DataBase-LINK.php'; // Adjust this to your DB connection file

$error_message = null;
$success_message = null;
$donation = null;
$hungerPoint = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fetch_details'])) {
        // Fetch details logic
        $donation_id = $_POST['D_Id'] ?? null;
        $hunger_point_id = $_POST['H_Id'] ?? null;

        if ($donation_id && $hunger_point_id) {
            // Fetch donation details
            $donation_query = "SELECT * FROM donations WHERE id = ?";
            $stmt = $connection->prepare($donation_query);
            $stmt->bind_param('i', $donation_id);
            $stmt->execute();
            $donation_result = $stmt->get_result();
            $donation = $donation_result->fetch_assoc();
            $donations = []; // Initialize the array outside the loop

            for ($i = 1; $i <= 3; $i++) { // Only 3 items in the SQL query
                $item_name = 'item_name_' . $i;
                $qty = 'qty_' . $i;
                $freshly_made = 'freshly_made_' . $i;

                if (!empty($donation[$item_name])) { // Check if the item exists
                    $donations[$donation['id']]['items'][] = [
                        'item_name' => $donation[$item_name],
                        'quantity' => $donation[$qty],
                        'is_fresh' => $donation[$freshly_made] ? 'Yes' : 'No',
                    ];
                }
            }

            // Fetch hunger point details
            $hunger_point_query = "SELECT * FROM needs WHERE id = ?";
            $stmt = $connection->prepare($hunger_point_query);
            $stmt->bind_param('i', $hunger_point_id);
            $stmt->execute();
            $hunger_point_result = $stmt->get_result();
            $hungerPoint = $hunger_point_result->fetch_assoc();


            if (!$donation || !$hungerPoint) {
                $error_message = "Invalid Donation ID or Hunger Point ID.";
            }
            $stmt->close();
        } else {
            $error_message = "Please provide both Donation ID and Hunger Point ID.";
        }
    } elseif (isset($_POST['accept_delivery'])) {
        // Accept delivery logic
        $donation_id = $_POST['D_Id'];
        $hunger_point_id = $_POST['H_Id'];

        // Mark donation as delivered in the database
        $delivery_query = "UPDATE donations SET status = 'delivered' WHERE donation_id = ?";
        $stmt = $connection->prepare($delivery_query);
        $stmt->bind_param('i', $donation_id);
        if ($stmt->execute()) {
            $success_message = "Delivery successfully accepted! Thank you for your contribution.";
        } else {
            $error_message = "Failed to accept delivery. Please try again.";
        }
        $stmt->close();
    }
    $connection->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliver Food</title>
    <link rel="stylesheet" href="deliverFood.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>

<body>
    <?php include '../assets/navbar.php'; ?> <!-- Navbar -->

    <h2 class="h22">Deliver Food</h2>
    <div class="main">
        <form action="deliverFood.php" method="post">
            <div class="input-group">
                <div class="head">
                    <h3>We truly appreciate your help!!</h3>
                </div>
                <div class="ip_main">
                    <div class="ip">
                        <label for="D_Id">Donation ID:</label>
                        <input type="text" name="D_Id" id="D_Id" placeholder="Enter Donation ID" value="<?= htmlspecialchars($_POST['D_Id'] ?? '') ?>" required>
                    </div>
                    <div class="ip">
                        <label for="H_Id">Hunger Point ID:</label>
                        <input type="text" name="H_Id" id="H_Id" placeholder="Enter Hunger Point ID" value="<?= htmlspecialchars($_POST['H_Id'] ?? '') ?>" required>
                    </div>
                </div>
                <button type="submit" name="fetch_details">Fetch Details</button>
            </div>
        </form>
        <?php if ($error_message): ?>
            <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
        <?php elseif ($success_message): ?>
            <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
        <?php elseif ($donation && $hungerPoint): ?>
            <h3 class="hh2">Fetched Details</h3>

            <div class="DD">
                <h4 class="hhh4">Donor Details:</h4>
                <div class="table">
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
                            <?php if (!empty($donations[$donation['id']]['items'])): ?>
                                <?php $j = 1; ?>
                                <?php foreach ($donations[$donation['id']]['items'] as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($j); ?></td>
                                        <td><?= htmlspecialchars($item['item_name']); ?></td>
                                        <td><?= htmlspecialchars($item['quantity']); ?></td>
                                        <td><?= htmlspecialchars($item['is_fresh']); ?></td>
                                    </tr>
                                    <?php $j++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No items donated.</td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
                <div class="Dtext">
                    <div class="text">
                        <p><strong>Landmark:</strong> <?= htmlspecialchars($donation['landmark']) ?></p>
                        <p><strong>Message:</strong> <?= htmlspecialchars($donation['message']) ?></p>
                    </div>
                    <div id="donor-map" data-lat="<?= htmlspecialchars($donation['latitude']) ?>" data-lng="<?= htmlspecialchars($donation['longitude']) ?>" style="height: 300px;"></div>
                </div>
            </div>
            <div class="HP">
                <h4 class="hhh4">Hunger Point Details:</h4>
                <div class="text">
                    <p><strong>Spot Type:</strong> <?= htmlspecialchars($hungerPoint['spot_type']) ?></p>
                    <p><strong>Food Needed For:</strong> <?= htmlspecialchars($hungerPoint['number_of_people']) ?> people</p>
                    <p><strong>Urgency:</strong> <?= $hungerPoint['urgent'] == 1 ? 'Urgent' : 'Normal'; ?></p>
                    <p><strong>Created At:</strong> <?= htmlspecialchars($hungerPoint['created_at']); ?></p>
                </div>
                <div id="hungerpoint-map" data-lat="<?= htmlspecialchars($hungerPoint['latitude']) ?>" data-lng="<?= htmlspecialchars($hungerPoint['longitude']) ?>" style="height: 300px;"></div>
            </div>

            <div class="final">
                <form action="Bookdeliver.php" method="post">
                    <input type="hidden" name="F_D_Id" value="<?= htmlspecialchars($donation['id']) ?>">
                    <input type="hidden" name="F_H_Id" value="<?= htmlspecialchars($hungerPoint['id']) ?>">
                    <label for="expected_date">Expected Delivery Date:</label>
                    <input type="date" id="expected_date" name="expected_date" required>
                    <button class="bttt" type="submit" name="accept_delivery">Accept Delivery</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Render Donor Map
            const donorMapElement = document.getElementById('donor-map');
            if (donorMapElement) {
                const lat = parseFloat(donorMapElement.dataset.lat);
                const lng = parseFloat(donorMapElement.dataset.lng);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const donorMap = L.map(donorMapElement).setView([lat, lng], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(donorMap);
                    L.marker([lat, lng]).addTo(donorMap).bindPopup('Donor Location').openPopup();
                }
            }

            // Render Hunger Point Map
            const hungerMapElement = document.getElementById('hungerpoint-map');
            if (hungerMapElement) {
                const lat = parseFloat(hungerMapElement.dataset.lat);
                const lng = parseFloat(hungerMapElement.dataset.lng);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const hungerMap = L.map(hungerMapElement).setView([lat, lng], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(hungerMap);
                    L.marker([lat, lng]).addTo(hungerMap).bindPopup('Hunger Point Location').openPopup();
                }
            }
        });
    </script>
</body>

</html>