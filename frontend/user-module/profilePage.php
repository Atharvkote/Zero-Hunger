<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - Profile page</title>
    <link rel="stylesheet" href="profile-style.css">

</head>

<body>
    <?php
    include '../essentails/navbar.html';  // import navbar as a componenet 
    ?>

    <div class="main-container">
        <div class="left">
            <div class="content">
                <div class="left-content">
                    <img src="../../images/Person-Logo.png" height="100px" width="100px">
                </div>
                <div class="right-content">
                    <h1>Atharva Kote</h1>
                    <h3>Regular Donar</h3>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="right-text">
                <h3>Atharva<!--<?php echo $_SESSION['username']; ?>-->'s Recent Activity</h3>
            </div>
            <div class="button-group">
                <button><b>Lorem ipsum dolor sit.</b></button>
                <button><b>Lorem ipsum dolor sit.</b></button>
                <button><b>Lorem ipsum dolor sit.</b></button>
                <button><b>Lorem ipsum dolor sit.</b></button>
                <button><b>Lorem ipsum dolor sit.</b></button>
            </div>
        </div>
        <div class="middle">
            <div class="left-mid">

            </div>
            <div class="right-mid">
                <div class="group-images">
                <img src="../../images/1st-Medal.png" alt="image" height=200px width="200px">
                <img src="../../images/2nd-Medal.png" alt="image" height=200px width="200px">
                <img src="../../images/3rd-Medal.png" alt="image" height=200px width="200px">
                </div>
        </div>
        </div>
    </div>


</body>

</html>