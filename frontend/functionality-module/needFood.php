<html>

<head>
  <title>Zero Hunger - Need Food</title>
  <link rel="stylesheet" href="need-Food.css">
  <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">
</head>

<body>
  <?php
  include '../assets/navbar.php';  // import navbar as a component 
  ?>
  <h2>Need Food</h2>
  <form action="need-food.php" method="post" enctype="multipart/form-data">
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

          <input type="file" id="camera-upload" accept="image/*" capture="camera" style="display:none;" onchange="previewMedia(event, 'camera')" multiple />
          <input type="file" id="gallery-upload" accept="image/*" style="display:none;" onchange="previewMedia(event, 'gallery')" multiple />
          <input type="file" id="video-upload" accept="video/*" style="display:none;" onchange="previewMedia(event)" />
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
