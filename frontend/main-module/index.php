 <?php
    // session_start();
    // if (!isset($_SESSION['username']) || $_SESSION['loggedin'] !== true) {
    //     header("Location: ../login-module/loginPage.php");
    //     exit();
    // }
    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="index-style.css">
     <link href="https://fonts.googleapis.com/css2?family=Inknut+Antique:wght@400;700&display=swap" rel="stylesheet">
     <title>Zero Hunger - Home</title>
 </head>

 <body>
     <?php
         include '../assets/navbar.html';  // import navbar as a componenet 
     ?>
     <div class="main-container">
         <div class="left">
             <h1>Zero Hunger - Be the Change</h1>
             <div class="content">
                 <div class="left-content">
                     <p>The Zero Hunger project is a website designed to help reduce food waste and fight hunger. It connects people who have extra food with those who need it.</p>
                 </div>
                 <div class="right-content">
                     <img src="../../images/Zero-Hunger-Logo.png" alt="image">
                 </div>
             </div>
             <div class="bottom-content">
                 <p> Donors can offer their surplus food, and people or organizations in need can request it. The platform helps make sure that good food isn't wasted and instead goes to those who need it the most.</p>
             </div>
         </div>

         <div class="right">
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

 </body>

 </html>