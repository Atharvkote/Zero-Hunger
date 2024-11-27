<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  include '../assets/DataBase-LINK.php';
  $spot_type = $_POST['spot_type'];
  $number_of_people = (int)$_POST['number_of_people'];
  $urgent = isset($_POST['urgent']) ? 1 : 0;

  $username = $_SESSION['username'];
  $email = $_SESSION['email'];

  // Insert data into the needs table
  $stmt = $connection->prepare("INSERT INTO needs (spot_type, number_of_people, urgent, username, email) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("siiss", $spot_type, $number_of_people, $urgent, $username, $email);
  $stmt->execute();
  $need_id = $stmt->insert_id;  // Get the last inserted id for `need_id`
  $stmt->close();

  // Handle file uploads (images and videos)
  $media_files = [];
  $media_file_paths = ""; // To store paths for a single file upload

  foreach ($_FILES as $file) {
    if ($file['error'] == UPLOAD_ERR_OK) {
      $target_dir = "uploads/";  // Define where files will be saved
      $target_file = $target_dir . basename($file["name"]);

      // Move the file to the uploads directory
      if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $media_files[] = $target_file;

        // If only one file is uploaded, store its path in `media_file_paths`
        if (count($media_files) == 1) {
          $media_file_paths = $target_file;  // Store the first file path for needs table
        } else {
          // Insert each additional file path into the needs-media table
          $stmt = $connection->prepare("INSERT INTO `needs-media` (need_id, file_path) VALUES (?, ?)");
          $stmt->bind_param("is", $need_id,  $media_file_paths);
          $stmt->execute();
          $stmt->close();
        }
      }
    }
  }

  // Update the needs table with the media file path if there was a single upload
  if ($media_file_paths !== "") {
    $stmt = $connection->prepare("UPDATE needs SET media_file_paths = ? WHERE id = ?");
    $stmt->bind_param("si", $media_file_paths, $need_id);
    $stmt->execute();
    $stmt->close();
  }

  // Redirect or display success message
  // echo "Form data and media files uploaded successfully!";           // De-Bugger



  // Tracking User Activity
  $username = $_SESSION['username'];
  $activity_description = "Requested  food  for $number_of_people peoples at $spot_type through Zero Hunger.";
  $sql="INSERT INTO `recent-activity` (`username`, `activity_description`, `activity_date`) VALUES ( '$username', '$activity_description', current_timestamp())";
  $request = mysqli_query($connection, $sql);

  // if($request){
  //   echo "Activity recorded successfully.";
  // }else{
  //   echo "Error recording activity.";
  // }

  $connection->close();
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
  <?php
  include '../assets/navbar.php';  // import navbar as a component 
  ?>
  <h2>Need Food</h2>
  <form action="needFood.php" method="post" enctype="multipart/form-data">
    <div class="main-content">
      <div class="left-panel">
        <h3>Enter Spot Type</h3>
        <p><i>( Can Be a Beggar Spot, Old Age Home, or Orphanage )</i></p>
        <select name="spot_type">
          <option value="beggar">Beggar Spot</option>
          <option value="orphanage">Orphanage</option>
          <option value="oldage">Old Age Home</option>
        </select>
        <div class="two-input">
          <div class="first">
            <p>Enter Number of People</p>
            <input max="100" min="1" type="number" name="number_of_people" required />
          </div>
          <div class="second">
            <p>Need Food On Urgent Basis</p>
            <p><input type="checkbox" name="urgent" /> Yes</p>
          </div>
        </div>
        <button type="button" class="location-button">
          <span>Add My Current Location</span>
          <img class="location-icon" src="../../images/Location.png" alt="location" />
        </button>
      </div>

      <div class="right-panel">
        <div class="image-placeholder" id="preview-container">
          <img id="preview" src="../../images/Image-Template.png" alt="Image Preview" />
        </div>
        <div class="option">
          <button type="button" class="btn" onclick="openCamera()">Add Visuals <img src="../../images/Camera.png" alt="Add Image" /></button>
          <button type="button" class="btn" onclick="openGallery()">From Gallery <img src="../../images/Photo.png" alt="From Gallery" /></button>
          <button type="button" class="btn" onclick="openVideoUpload()">Add Video <img src="../../images/Video.png" alt="Add Video" /></button>

          <input type="file" name="camera_upload[]" id="camera-upload" accept="image/*" capture="camera" style="display:none;" onchange="previewMedia(event, 'camera')" multiple />
          <input type="file" name="gallery_upload[]" id="gallery-upload" accept="image/*" style="display:none;" onchange="previewMedia(event, 'gallery')" multiple />
          <input type="file" name="video_upload" id="video-upload" accept="video/*" style="display:none;" onchange="previewMedia(event)" />

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
</body>

</html>