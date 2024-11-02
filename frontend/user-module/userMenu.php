<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - User Menu</title>
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inknut Antiqua", serif;
            background-color: #fff5e6;
            min-height: 100vh;
        }

        h3{
            background-color: #ff8d02;
            border-radius: 0px 20px 20px 0px ;
            padding: 5px 0px 10px 40px ;
            margin-right: 20%;

        }

        .container-option{
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            background-color: #f5d8b5;
            padding: 0px 20px 20px 20px;
            margin: 30px 20% 0px 20%;
            border-radius: 25px;
        }
        .container-option button{
            padding: 10px 60px;
            max-width: 50%;
            width: 100%;
            margin: 20px 40px 0px 27%;
            font-family: "Inknut Antiqua", serif;
            background-color: #ff8d02;
            border: none;
            border-radius: 20px;
            transition: 0.3s ease;
            font-size: 16px;
            color: black;
        }

        .container-option button:hover{
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <?php
    include '../assets/navbar.html';  // import navbar as a componenet 
    ?>

<h3>Zero Hunger is an Open -Source Project, and we are always looking for contributors!</h3>
    <div class="container-option">
        <div class="group">
            <a href="#"><button><b>Edit Profile</b></button></a>
            <a href="../main-module/contactUs.php"><button><b>Report Issue</b></button></a>
            <a href="https://github.com/Atharvkote/Zero-Hunger.git"><button><b>Contribute to this Project</b></button></a>
            <a href="../login-module/logout.php"><button><b>Log Out</b></button></a>
            </div>
    </div>
</body>

</html>