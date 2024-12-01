<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include '../assets/DataBase-LINK.php'; // Make sure this path is correct

  // Get form inputs
  $spot_type = $_POST['spot_type'];
  $number_of_people = (int)$_POST['number_of_people'];
  $urgent = isset($_POST['urgent']) ? 1 : 0;

  // Get latitude and longitude from the hidden inputs
  $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : null;
  $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : null;

  // Get user session data
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];

  // Insert data into the needs table, including latitude and longitude
  $stmt = $connection->prepare("INSERT INTO needs (spot_type, number_of_people, urgent, username, email, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("siissdd", $spot_type, $number_of_people, $urgent, $username, $email, $latitude, $longitude);
  $stmt->execute();
  $need_id = $stmt->insert_id;
  $stmt->close();

  // Handle file uploads (image/video from gallery or custom media upload)

  // Handle media-upload (if exists)
  if (isset($_FILES['media_upload']) && $_FILES['media_upload']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['media_upload'];
    $target_dir = "../../uploads/"; // Change to your desired upload directory
    $target_file = $target_dir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
      // Insert media file path into the database
      $stmt = $connection->prepare("INSERT INTO `needs-media` (need_id, file_path) VALUES (?, ?)");
      $stmt->bind_param("is", $need_id, $target_file);
      $stmt->execute();
      $stmt->close();
    }
  }

  // Handle gallery-upload (if exists, can be image or video)
  if (isset($_FILES['from_gallery']) && $_FILES['from_gallery']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['from_gallery'];
    $target_dir = "../../uploads/"; // Directory for uploads
    $target_file = $target_dir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
      // Insert file path into the database
      $stmt = $connection->prepare("INSERT INTO `needs-media` (need_id, file_path) VALUES (?, ?)");
      $stmt->bind_param("is", $need_id, $target_file);
      $stmt->execute();
      $stmt->close();
    }
  }

  // Handle video-upload (if exists)
  if (isset($_FILES['add_video']) && $_FILES['add_video']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['add_video'];
    $target_dir = "../../uploads/"; // Directory for uploads
    $target_file = $target_dir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
      // Insert video file path into the database
      $stmt = $connection->prepare("INSERT INTO `needs-media` (need_id, file_path) VALUES (?, ?)");
      $stmt->bind_param("is", $need_id, $target_file);
      $stmt->execute();
      $stmt->close();
    }
  }

  // Track user activity
  $activity_description = "Requested food for $number_of_people people at $spot_type through Zero Hunger.";
  $stmt = $connection->prepare("INSERT INTO `recent-activity` (username, activity_description, activity_date) VALUES (?, ?, current_timestamp())");
  $stmt->bind_param("ss", $username, $activity_description);
  $stmt->execute();
  $stmt->close();


  $search = "SELECT COUNT(*) AS total_reports
  FROM needs
  WHERE username = '$username'";

  // Execute the query
  $result = $connection->query($search);

  // Check if the query was successful
  if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();
    $needValue = $row['total_reports'];  // Get the total reports count

    // Call the function to update the user's progress after the report
    include 'ZHcardUpdater.php';
    updateAfterReport($username, $needValue);
  }
  // Close the connection and redirect to the success page
  $connection->close();
  header("Location: needFood.php"); // Redirect to a success page (optional)
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zero Hunger - Need Food</title>
  <link rel="stylesheet" href="need-Food.css">
  <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
</head>

<body>
  <?php include '../assets/navbar.php'; ?>

  <h2 class="h22">Need Food</h2>
  <form action="needFood.php" method="post" enctype="multipart/form-data">
    <div class="main-content">
      <div class="left-panel">
        <h3>Enter Spot Type</h3>
        <p><i>(Can Be a Beggar Spot, Old Age Home, or Orphanage)</i></p>
        <select name="spot_type" required>
          <option value="beggar">Beggar Spot</option>
          <option value="orphanage">Orphanage</option>
          <option value="oldage">Old Age Home</option>
        </select>
        <div class="two-input">
          <div class="first">
            <p>Enter Number of People</p>
            <input type="number" name="number_of_people" min="1" max="100" required />
          </div>
          <div class="second">
            <p>Need Food On Urgent Basis</p>
            <p><input type="checkbox" name="urgent" /> Yes</p>
          </div>
        </div>
        <button type="button" class="location-button" onclick="getCurrentLocation()">
          <span>Add My Current Location</span>
          <input type="hidden" name="latitude" id="latitude" />
          <input type="hidden" name="longitude" id="longitude" />
          <img class="location-icon" src="../../images/Location.png" alt="location" />
        </button>
      </div>

      <div class="right-panel">
        <div class="image-placeholder" id="preview-container">
          <img id="preview" src="../../images/Image-Template.png" alt="Image Preview" />
        </div>
        <div class="option">
          <!-- Add visuals button -->
          <button type="button" class="btn" onclick="triggerInput('media-upload')">Add Visuals <img src="../../images/Camera.png" alt="Add Image" /></button>
          <!-- From Gallery button -->
          <button type="button" class="btn" onclick="triggerInput('gallery-upload')">From Gallery <img src="../../images/Photo.png" alt="From Gallery" /></button>
          <!-- Add video button -->
          <button type="button" class="btn" onclick="triggerInput('video-upload')">Add Video <img src="../../images/Video.png" alt="Add Video" /></button>

          <!-- Hidden input fields for media uploads -->
          <input type="file" name="media_upload" id="media-upload" accept="image/*" style="display:none;" onchange="previewMedia(event)" />
          <input type="file" name="from_gallery" id="gallery-upload" accept="image/*,video/*" style="display:none;" onchange="previewMedia(event)" />
          <input type="file" name="add_video" id="video-upload" accept="video/*" style="display:none;" onchange="previewMedia(event)" />
        </div>
      </div>
    </div>

    <div class="footer">
      <p class="warning">
        If any type of malpractices found (fake or duplicate entry) will be banned from the website.
      </p>
      <input class="submit-button" type="submit" value="Submit" />
    </div>
  </form>
  <script src="mediaPreveiwer.js"></script>
  <script src="locationTracker-needs.js"></script>
</body>

</html>