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
        include '../assets/navbar.html';  // import navbar as a componenet 
    ?>
    <div class="main-container">
        <div class="left">
            <div class="content">
                <div class="left-content">
                    <img src="../../images/Person-Logo.png" height="100px" width="100px">
                </div>
                <div class="right-content">
                    <h1>Atharva Kote</h1>
                    <p> Rank : Regular Donor</p>
                </div>
            </div>
            <!-- Add this new container for the bottom images -->
            <div class="middle">
                <div class="info">
                    <ul>
                        <li><strong>Email :</strong> atharvakote@gmail.com</li>
                        <li><strong>State :</strong> Maharathra</li>
                        <li><strong>District :</strong> Ahilyanagar</li>
                    </ul>
                </div>
                <div class="bottom-images">
                    <img src="../../images/1st-Medal.png" alt="image" height="50px" width="50px">
                    <img src="../../images/2nd-Medal.png" alt="image" height="50px" width="50px">
                    <img src="../../images/3rd-Medal.png" alt="image" height="50px" width="50px">
                </div>
            </div>
        <div class="bio">
            <h3>About <!--<?php $_SESSION['username']?>--> Atharva :</h3>
            <p>Hey! I am Atharva Kote from Shirdi,Maharthra , a proud Regular Donar at ZERO Hunger .Chasing that 1% that can change 99% </p>
        </div>
        </div>

        <div class="right">
            <div class="right-text">
                <h3>Atharva<!--<?php echo $_SESSION['username']; ?>-->'s Recent Activity</h3>
            </div>
            <div class="button-group">
                <button><b>Donated Rs. 300 to Charity Fund.</b><img src="../../images/Black-Arrow.png" height="40px" width="30px"></button>
                <button><b>Delivered 2 Food Batches.</b><img src="../../images/Black-Arrow.png" height="40px" width="30px"></button>
                <button><b>Donated Rs. 4300 to Charity Fund</b><img src="../../images/Black-Arrow.png" height="40px" width="30px"></button>
                <button><b>Reported 2 Active Points.</b><img src="../../images/Black-Arrow.png" height="40px" width="30px"></button>
                <button><b>Reported 7 Active Points.</b><img src="../../images/Black-Arrow.png" height="40px" width="30px"></button>
            </div>
        </div>


</body>

</html>