<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zero Hunger - Volunteer Registration</title>
  <link href="volunteer-style.css" rel="stylesheet" />
  <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
</head>

<body>
  <?php
  include '../assets/navbar.php';  // import navbar as a componenet 
  ?>
    <form action="Emailing_Process.php" method="post">

  <h2 class="heading">Volunteer Registration</h2>
  <div class="container">
    <div class="form-container">
      <div class="form-group">
        <label for="mobile-number">Enter Your Mobile Number</label>
        <input name="mobile-number" placeholder="Enter Your Personal Contact Mobile Number" type="tel" />
      </div>

      <div class="form-group date-icon">
        <label for="birth-date">Birth Date</label>
        <input name="birth-date" type="date" placeholder="Your Birth Date" />
      </div>

      <div class="form-group">
        <label for="address">Residential Address</label>
        <textarea name="address" placeholder="Enter Your Address"></textarea>
      </div>

      <h2 class="subheading">Volunteer Role</h2>

      <div class="volunteer-role">
        <div class="checkboxx">
          <div class="check">
            <input name="serving-agent" type="checkbox" />
            <label for="serving-agent">Serving Agent</label>
          </div>
          <div class="check">
            <input name="food-collector" type="checkbox" />
            <label for="food-collector">Food Collector</label>
          </div>
          <div class="check">
            <input name="quality-manager" type="checkbox" />
            <label for="quality-manager">Quality Manager</label>
          </div>
          <div class="check">
            <input name ="developer" type="checkbox" />
            <label for="developer">Developer</label>
          </div>
        </div>
        <div class="role-guide">
          <a href="#"><button class="role-guide">Role Guide</button></a>
          <a href="#"><button class="role-guide">Role Guide</button></a>
          <a href="#"><button class="role-guide">Role Guide</button></a>
          <a href="#"><button class="role-guide">Role Guide</button></a>
        </div>
      </div>

    </div>
    <div class="info-container">
      <img height="600px" width="500px" src="../../images/Red-Heart-Front-Logo.png" />
      <h2>Join Us ! As a Volunteer</h2>
      <div class="submit-warning">
        <h3>Instructions</h3>
        <ol>
          <li>Multiple Role for one volunter is Possible, In this Individual should be able to perform all the roles</li>
          <li>Serious action will be taken against Fake Submission,</li>
          <li>After Selection as volunteer, Causal Behevoir will not be entertained</li>
        </ol>
      </div>
      <button class="submit-button-new">Submit</button>
    </div>
  </div>
    </form>
</body>

</html>