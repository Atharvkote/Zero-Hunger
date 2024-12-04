<?php
// db_connection.php: Database connection (ensure it's included at the top)
include '../assets/DataBase-LINK.php';

// Start session to get user information based on username
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get user data from the database based on the username
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect the form data
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $bio = mysqli_real_escape_string($connection, $_POST['bio']);
    $state = mysqli_real_escape_string($connection, $_POST['state']);
    $pincode = mysqli_real_escape_string($connection, $_POST['pincode']);
    $district = mysqli_real_escape_string($connection, $_POST['district']);
    $city = mysqli_real_escape_string($connection, $_POST['city']);
    $profile_photo = $user['profile_photo']; // Default to current photo

    // Handle the profile photo upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $upload_dir = '../../uploads/';

        // Create 'uploads' directory if it doesn't exist
        // if (!is_dir($upload_dir)) {
        //     mkdir($upload_dir, 0777, true);
        // }

        $file_name = $_FILES['profile_photo']['name'];
        $file_tmp = $_FILES['profile_photo']['tmp_name'];
        $file_path = $upload_dir . basename($file_name);

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($file_tmp, $file_path)) {
            $profile_photo = $file_path; // Update profile photo path
        }
    }

    // Update the user profile in the database
    $update_query = "UPDATE users SET name = '$name', bio = '$bio', state = '$state', pincode = '$pincode', district = '$district', city = '$city', profile_photo = '$profile_photo' WHERE username = '$username'";
    if (mysqli_query($connection, $update_query)) {
        echo "Profile updated successfully.";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
    <title>Zero Hunger - Edit Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional, for styling -->
</head>

<body>
    <?php
    include '../assets/navbar.php';  // Import navbar as a component 
    ?>
    <div class="profile-container">
        <h2>Edit Profile</h2>
        <div class="whole_2">
            <div class="form-con">
                <form method="POST" enctype="multipart/form-data">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>

                    <label for="bio">Bio:</label>
                    <textarea id="bio" name="bio"><?php echo $user['bio']; ?></textarea>

                    <label for="state">State:</label>
                    <input type="text" id="state" name="state" value="<?php echo $user['state']; ?>">

                    <label for="pincode">Pincode:</label>
                    <input type="text" id="pincode" name="pincode" value="<?php echo $user['pincode']; ?>">

                    <label for="district">District:</label>
                    <input type="text" id="district" name="district" value="<?php echo $user['district']; ?>">

                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="<?php echo $user['city']; ?>">

                    <label for="profile_photo">Profile Photo:</label>
                    <div class="previewer">
                        <input type="file" id="profile_photo" name="profile_photo">
                        <img src="<?php echo $user['profile_photo']; ?>" alt="Profile Photo" class="profile-photo-preview">
                    </div>
                    <button type="submit">Update Profile</button>
                </form>
            </div>
            <div class="side-img">
                <img src="../../images/side-img.png" alt="" srcset="">
                <!-- <img src="../../images/Milestone.png" alt="" srcset=""> -->
            </div>
        </div>
</body>

</html>