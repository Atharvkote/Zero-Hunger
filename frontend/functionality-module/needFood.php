<html>

<head>
  <title>Zero Hunger - Need Food</title>
  <link rel="stylesheet" href="need-Food.css">
  <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">

</head>

<body>
  <?php
  include '../assets/navbar.php';  // import navbar as a componenet 
  ?>
  <h2>Need Food</h2>
  <form action="need-food.php" method="post">
  <div class="main-content">
   
    <div class="left-panel">
      <h3>Enter Spot Type</h3>
      <p><i>( Can Be a Beggar Spot, Old Age Home, or Orphanage )</i></p>
      <select>
        <option>Beggar Spot</option>
        <option>Orphanage</option>
        <option>Oldage Home</option>
      </select>
      <div class="two-input">
        <div class="first">
          <p>Enter Number of People</p>
          <input max="100" min="1" type="number" />
        </div>
        <div class="second">
          <p>Need Food On Urgent Basis</p>
          <p><input type="checkbox" /> Yes</p>
        </div>
      </div>
      <button class="location-button">
        <span>Add My Current Location</span>
        <img class="location-icon" src="../../images/Location.png" alt="location"/>
      </button>
    </div>

    <div class="right-panel">
      <div class="image-placeholder"></div>
      <div class="option">
        <button class="btn">Add Visuals <img  src="../../images/Camera.png" alt="location"/></button>
        <button class="btn">From Gallery <img  src="../../images/Photo.png" alt="location"/></i></button>
        <button class="btn">Add Video <img src="../../images/Video.png" alt="location"/></button>
      </div>
    </div>
  </div>
  <div class="foooter">
    <p class="warning">
      If any type of malpractices found (fake or duplicate entry) will be banned from the website.
    </p>
    <input class="submit-button" type="submit"  value="Submit"/>

  </div>

  </form>
</body>

</html>