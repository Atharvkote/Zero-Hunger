<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zero Hunger</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="sponser-style.css">
  <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
</head>

<body>
  <div class="whole1" id="blurr1">
    <?php
    include '../assets/navbar.php';  // import navbar as a componenet 
    ?>
    <div class="main-content">
      <h2 class="heading">Become Sponsor of Zero Hunger</h2>
      <div class="donation-section">
        <h3>Help us make a difference</h3>
        <p>Every Rupee counts, and with your donation, we can provide food for those in need.</p>
        <img alt="Donations appreciated sign with a plant and a jar of money" height="200" src="../../images/Sponser-Image.jpg" width="400" />
        <button>Net Banking</button>
        <button onclick="toggleSponser()">QR Code</button>
      </div>
    </div>



    <div class="footer">
      Sponsoring is not mandatory; it is completely up to you if you'd like to contribute.
    </div>
  </div>


  <div id="popup1">
    <h3>Here is there QR-Code</h3>
    <div class="QR">
      <img src="../../images/QR-Code.png" alt="QR" height="100px" width="100px">
    </div>
    <button class="cbutton" onclick="toggleSponser()" type="button"><b>Close</b></button>
  </div>

  <script src="../login-module/popUpToggler.js"></script>
</body>

</html>