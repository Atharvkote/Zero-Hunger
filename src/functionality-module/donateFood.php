<?php
session_start();
$showError = $showAlert = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../assets/DataBase-LINK.php';

    if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
    }

    $latitude = isset($_GET['latitude']) ? $_GET['latitude'] : null;
    $longitude = isset($_GET['longitude']) ? $_GET['longitude'] : null;
    
    $landmark = $_POST['landmark'];
    $day = $_POST['day'];
    $message = $_POST['message'];

    // Initialize items array
    $items = [];
    $counter = 0;
    for ($i = 1; $i <= 5; $i++) {
        if (!empty($_POST["item-$i"])) { // Check if item name is provided
            $items[] = [
                'name' => $_POST["item-$i"],
                'qty' => $_POST["qty-$i"],
                'freshly_made' => isset($_POST["freshly-made-$i"]) ? 1 : 0
            ];
            $counter++;
        }
    }

    // Start building the query dynamically
    $sql = "INSERT INTO donations (landmark, day, message, username, email";
    $values = "VALUES (?, ?, ?, ?, ?";
    $params = [$landmark, $day, $message, $username, $email];
    $types = "sssss";

    // Add latitude and longitude if available
    if ($latitude && $longitude) {
        $sql .= ", latitude, longitude";
        $values .= ", ?, ?";
        $params[] = $latitude;
        $params[] = $longitude;
        $types .= "dd"; // d: double for latitude and longitude
    }

    // Loop through items to add to the query only if data is present
    foreach ($items as $index => $item) {
        $itemIndex = $index + 1;
        $sql .= ", item_name_$itemIndex, qty_$itemIndex, freshly_made_$itemIndex";
        $values .= ", ?, ?, ?";
        $params[] = $item['name'];
        $params[] = $item['qty'];
        $params[] = $item['freshly_made'];
        $types .= "sis"; // s: string, i: integer, s: string (boolean)
    }

    $sql .= ") $values)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    $stmt->close();

    // Log activity in recent_activity table
    $activity_description = "Donated food for $counter item on $day through Zero Hunger.";
    $sql = "INSERT INTO `recent-activity` (username, activity_description, activity_date) VALUES (?, ?, CURRENT_TIMESTAMP)";
    $activity_stmt = $connection->prepare($sql);
    $activity_stmt->bind_param("ss", $username, $activity_description);
    $activity_stmt->execute();

    $activity_stmt->close();
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - Donate Food</title>
    <link rel="stylesheet" href="donate-Food.css">
    <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
</head>

<body>
    <?php
    include '../assets/navbar.php';  // import navbar as a componenet 
    ?>
      <div class="container">
        <div class="left-column">
            <form action="donateFood.php" method="post">
                <div class="section-title">Donate Food</div>
                <div class="upper">
                    <div class="form-group">
                        <label>Enter Your Residence Address/Landmark Name</label>
                        <input name="landmark" placeholder="Enter name of your shop or mess or a hotel if not mention nearest landmark" type="text"  required>
                    </div>
                    <div class="form-group">
                        <label>Mention Day Food was Made</label>
                        <input name="day" placeholder="Enter day food was made" type="date" required>
                    </div>
                    <div class="form-group">
                        <label>Message for Receiver - Type something special</label>
                        <textarea name="message" placeholder="Message for the receiver"></textarea>
                    </div>
                    <button type="button" onclick="sendLocation()" type="submit" class="location-button">
                        <span>Add My Current Location</span>
                        <img class="location-icon" src="../../images/Location.png" alt="location"  required>
                    </button>
                </div>
                <div class="section-title">Food Details</div>
                <div class="food-details">
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input name="item-1" placeholder="Enter name of food" type="text" required>
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-1" placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-1" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input name="item-2" placeholder="Enter name of food" type="text" />
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-2" placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-2" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input name="item-3" placeholder="Enter name of food" type="text" />
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-3" placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-3" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input name="item-4" placeholder="Enter name of food" type="text" />
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-4" placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-4" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input name="item-5" placeholder="Enter name of food" type="text" />
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-5" placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-5" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                </div>

        </div>
        <div class="right-panel">
            <div class="image-placeholder"></div>
            <div class="option">
                <button class="btn">Add Visuals <img src="../../images/Camera.png" alt="location" /></button>
                <button class="btn">From Gallery <img src="../../images/Photo.png" alt="location" /></i></button>
                <button class="btn">Add Video <img src="../../images/Video.png" alt="location" /></button>
            </div>

            <div class="message">
                <img src="../../images/Red-Heart-Logo.png" alt="red" class="red" height="100px" width="100px">
                <p>You doing a great work !!!</p>
                <p>Putting a step toward mutual group of human care worldwide</p>
            </div>
            <div class="foooter">
                    <p class="warning">
                        If any type of malpractices found (fake or duplicate entry) will be banned from the website.
                    </p>
                    <input class="submit-button" type="submit" value="Submit Donation"/>
                </div>
            </form>
        </div>
    </div>
    <script src="locationTracker.js"></script>
</body>

</html>