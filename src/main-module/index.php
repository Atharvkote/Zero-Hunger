<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login-module/loginPage.php");
    exit();
}

include '../assets/DataBase-LINK.php'; // Include your database connection file

$showError = "";

$user = $_SESSION['username'];
// Fetch milestone data
$numberOfUser = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `users-information`"));
$hungerPoint = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `needs`"));
$donations = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `donations`"));


// Define goal values (could also be fetched from the database)
$goalDonations = 50;
$goalHungerPoints = 50;
$goalActiveUsers = 50;

// Calculate percentages
$donationsPercentage = ($donations / $goalDonations) * 100;
$hungerPointsPercentage = ($hungerPoint / $goalHungerPoints) * 100;
$activeUsersPercentage = ($numberOfUser / $goalActiveUsers) * 100;



// Fetch deliveries assigned to the logged-in user
$repo = "SELECT * FROM `deliveries` WHERE `delivered_by` = '$user'";
$query = mysqli_query($connection, $repo);

// Check if the query was successful
if ($query && mysqli_num_rows($query) > 0) {
    $flag = True;
} else {
    $flag = false; // No deliveries found
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - Home Page</title>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" /> -->
    <link rel="stylesheet" href="index-style.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.7/themes/odometer-theme-default.css"
        integrity="sha512-kMPqFnKueEwgQFzXLEEl671aHhQqrZLS5IP3HzqdfozaST/EgU+/wkM07JCmXFAt9GO810I//8DBonsJUzGQsQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
</head>

<body>
    <?php
    include '../assets/navbar.php';  // import navbar as a componenet 
    ?>


    <div class="mh2">
        <h2>Milestone Reched Till Now </h2>
        <img src="../../images/Discuss.png" alt="nilestonses" height="200px" width="200px">
        <img src="../../images/Pre-Goal.png" alt="nilestonses" height="200px" width="200px">
        <img src="../../images/Final.png" alt="nilestonses" height="200px" width="200px">
    </div>
    <div class="milestone">
        <div class="stats-container">
            <div class="stat">
                <div class="odometer plus" data-value="<?php echo 1000; ?>">0</div>
                <div class="type">Lives Nourished</div>
            </div>
            <div class="stat">
                <div class="odometer plus" data-value="<?php echo $donations; ?>">0</div>
                <div class="type">Donations</div>
            </div>
            <div class="stat">
                <div class="odometer plus" data-value="<?php echo $hungerPoint; ?>">0</div>
                <div class="type">Hunger Point</div>
            </div>
            <div class="stat">
                <div class="odometer" data-value="<?php echo $numberOfUser; ?>">0</div>
                <div class="type">Active User</div>
            </div>
        </div>
    </div>
    <div class="hh2">
        <h2>Zero Hunger - Be the Change You Want See In World</h2>
    </div>
    <div class="content">
        <div class="box">
            <img alt="Zero Hunger Logo" height="150" src="../../images/Zero-Hunger-Logo.png" width="200" />
            <p>Zero Hunger project<strong><i> is a social initiative aimed at reducing food waste</i></strong> and alleviating hunger by connecting those with surplus food to those in need. Designed as a user-friendly website, it acts as a <strong><i> bridge between donors, such as households, restaurants, and grocery stores with extra food, and individuals or organizations seeking food assistance.</i></strong></p>
            <p>Donors can easily list their surplus food items, specifying details such as quantity, freshness, and any special instructions for storage or handling. <strong><i>Those in need, whether individuals facing food insecurity or community organizations, can browse available donations or submit specific requests.</i></strong></p>
            <div class="writer">
                <h3>~ Team BYPAS07</h3>
            </div>
        </div>
        <div class="box right">
            <div class="right-text">
                <p> अन्नपूर्णे सदापूर्णे नित्यपूर्णे जगत्पोषे।<br>
                    रक्षिणी संसारस्य सर्वस्य कुरु कुशलम्। </p>
            </div>
            <div class="button-group">
                <a href="../functionality-module/needFood.php"><button><b>Need Food</b></button></a>
                <a href="../functionality-module/donateFood.php"><button><b>Donate Food</b></button></a>
                <a href="../volunteer-module/volunteer.php"><button><b>Volunteer</b></button></a>
                <a href="../sponser-module/sponser.php"><button><b>Sponser Us</b></button></a>
            </div>
        </div>
    </div>
    <?php
if ($flag) {
    echo '<h2 class="hh2">Deliveries Assigned to You</h2>';
    echo '<div class="deliveries-container">';
    // Assuming $connection is already included and connected
    $query = "SELECT * FROM `deliveries` WHERE `delivered_by` = '$user'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="main-c">';
        echo "<ul class='deliveries-list'>";
        while ($row = mysqli_fetch_assoc($result)) {
            // Retrieve latitude and longitude for donor and hunger point
            $donationId = $row['donation_id'];
            $hungerPointId = $row['hunger_point_id'];

            // Query to get donor location
            $donorQuery = "SELECT latitude, longitude FROM `donations` WHERE `id` = '$donationId'";
            $donorResult = mysqli_query($connection, $donorQuery);
            $donorData = mysqli_fetch_assoc($donorResult);

            // Query to get hunger point location
            $hungerPointQuery = "SELECT latitude, longitude FROM `needs` WHERE `id` = '$hungerPointId'";
            $hungerPointResult = mysqli_query($connection, $hungerPointQuery);
            $hungerPointData = mysqli_fetch_assoc($hungerPointResult);

            // Format dates for JavaScript
            $deliveryDate = date("Y-m-d H:i:s", strtotime($row['delivery_date']));
            $expectedDate = date("Y-m-d H:i:s", strtotime($row['expected_delivery_date']));

            echo "<li class='delivery-item'>";
            echo "<h3><strong>Delivery Number :</strong> " . $row['id'] . "</h3>";
            echo "<p><strong>Donation ID:</strong> " . $donationId . "</p>";
            echo "<p><strong>Hunger Point ID:</strong> " . $hungerPointId . "</p>";
            echo "<p><strong>Delivery Date:</strong> " . $row['delivery_date'] . "</p>";
            echo "<p><strong>Expected Delivery Date:</strong> " . $row['expected_delivery_date'] . "</p>";
            echo "<div class='countdown' data-start='$deliveryDate' data-end='$expectedDate'></div>";

            // Add "Get Directions" buttons if locations are available
            if ($donorData && $hungerPointData) {
                $donorLat = $donorData['latitude'];
                $donorLng = $donorData['longitude'];
                $hungerLat = $hungerPointData['latitude'];
                $hungerLng = $hungerPointData['longitude'];
                echo'<div class="locate">';
                echo "<button  onclick=\"window.open('https://www.google.com/maps/dir/?api=1&destination=$donorLat,$donorLng', '_blank')\">Get Directions to Donor</button>";
                echo "<button onclick=\"window.open('https://www.google.com/maps/dir/?api=1&destination=$hungerLat,$hungerLng', '_blank')\">Get Directions to HP</button>";
                echo'</div>';
            } else {
                echo "<p>Location details not available.</p>";
            }

            echo "</li>";
        }
        echo "</ul>";
        echo '</div>';

        echo '<div class="main-child">
            <img src="../../images/Timer.png" alt="timer" height="300px" width="300px">
        </div>';
    } else {
        echo "<p>No delivery records found.</p>";
    }
}
?>


    <script>
        // JavaScript for handling the countdown timer
        document.addEventListener('DOMContentLoaded', function() {
            const countdowns = document.querySelectorAll('.countdown');
            countdowns.forEach(function(countdown) {
                const startDate = new Date(countdown.getAttribute('data-start'));
                const endDate = new Date(countdown.getAttribute('data-end'));

                function updateTimer() {
                    const now = new Date();
                    const timeRemaining = endDate - now;

                    if (timeRemaining <= 0) {
                        countdown.innerHTML = "<p style='color: red;'>Delivery Overdue!</p>";
                        clearInterval(timerInterval);
                    } else {
                        const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                        countdown.innerHTML = `
                        <p><strong>Time Remaining:</strong> ${days}d : ${hours}h : ${minutes}m : ${seconds}s</p>
                    `;
                    }
                }

                updateTimer();
                const timerInterval = setInterval(updateTimer, 1000);
            });
        });
    </script>

    </div>

    <div class="hh2">
        <h2>Our Vision and Missions</h2>
    </div>

    <div class="container">
        <div class="vision-mission">
            <!-- Vision Box -->
            <div class="box2">
                <img src="../../images/vision.png" alt="Vision" height="500px" width="500px" class="box-img">
                <h2>Our Vision</h2>
                <p>A world free of hunger, where every individual has access to nutritious food, and communities thrive by fostering a culture of sharing, sustainability, and compassion.</p>
            </div>
            <!-- Mission Box -->
            <div class="box2">
                <img src="../../images/mission.png" alt="Mission" class="box-img">
                <h2>Our Mission</h2>
                <p>To bridge the gap between food surplus and scarcity by creating an efficient, accessible, and transparent platform that connects donors with those in need. Through technology and community collaboration, we aim to minimize food waste, promote sustainability, and ensure no one sleeps hungry.</p>
            </div>
        </div>
    </div>


    <div class="mh2">
        <img src="../../images/1.png" alt="milestonses" height="200px" width="200px">
        <img src="../../images/2.png" alt="milestonses" height="200px" width="200px">
        <img src="../../images/3.png" alt="milestonses" height="200px" width="200px">
        <h2>Goal Setting and Current Status</h2>
    </div>
    <div class="goal-progress-container">

        <div class="goal-card">
            <div class="goal-info">
                <img src="../../images/Donation.png" alt="Donation Icon" class="goal-icon">
                <div class="goal-details">
                    <div class="goal-type">Donations Goal</div>
                    <div class="goal-progress-bar">
                        <div class="progress-bar" style="width: <?php echo $donationsPercentage; ?>%"></div>
                    </div>
                    <div class="goal-percentage"><?php echo round($donationsPercentage, 2); ?>% Reached</div>
                </div>
            </div>
        </div>

        <div class="goal-card">
            <div class="goal-info">
                <img src="../../images/Hunger.png" alt="Hunger Points Icon" class="goal-icon">
                <div class="goal-details">
                    <div class="goal-type">Hunger Points Goal</div>
                    <div class="goal-progress-bar">
                        <div class="progress-bar" style="width: <?php echo $hungerPointsPercentage; ?>%"></div>
                    </div>
                    <div class="goal-percentage"><?php echo round($hungerPointsPercentage, 2); ?>% Reached</div>
                </div>
            </div>
        </div>

        <div class="goal-card">
            <div class="goal-info">
                <img src="../../images/User.png" alt="User Icon" class="goal-icon">
                <div class="goal-details">
                    <div class="goal-type">Active Users Goal</div>
                    <div class="goal-progress-bar">
                        <div class="progress-bar" style="width: <?php echo $activeUsersPercentage; ?>%"></div>
                    </div>
                    <div class="goal-percentage"><?php echo round($activeUsersPercentage, 2); ?>% Reached</div>
                </div>
            </div>
        </div>

        <div class="goal-card">
            <div class="goal-info">
                <img src="../../images/Nourish.png" height="200px" width="200px" alt="Noured Lives Icon" class="goal-icon">
                <div class="goal-details">
                    <div class="goal-type">Noured Lives Goal</div>
                    <div class="goal-progress-bar">
                        <div class="progress-bar" style="width: 20%"></div> <!-- Set initial width to 0% -->
                    </div>
                    <div class="goal-percentage">20% Reached</div> <!-- Initial percentage -->
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../assets/footer.php';
    ?>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.7/odometer.min.js"
        integrity="sha512-v3fZyWIk7kh9yGNQZf1SnSjIxjAKsYbg6UQ+B+QxAZqJQLrN3jMjrdNwcxV6tis6S0s1xyVDZrDz9UoRLfRpWw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>

    <script src="Counter.js"></script>

    <script>
        // Example JavaScript to update the progress dynamically
        document.querySelectorAll('.goal-card').forEach(card => {
            const progressBar = card.querySelector('.progress-bar');
            const percentage = progressBar.style.width;

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        progressBar.style.width = percentage;
                        observer.disconnect();
                    }
                });
            }, {
                threshold: 0.5
            });

            observer.observe(card);
        });
    </script>
</body>

</html>