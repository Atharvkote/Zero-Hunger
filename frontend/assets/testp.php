<?php
session_start();
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login-style.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">

    <title></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap');

        body {
            font-family: 'Inknut Antiqua', serif;
            margin: 0;
            background-color: #fff5e6;
            padding: 0;
            width: 100%;
        }

        header {
            background-color: #ff8d02;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-logo {
            margin-left: auto;
            margin-top: -35px;
        }

        .logo h1 {
            margin: 0;
            font-size: 36px;
            color: white;
            margin-left: 20px;
            margin-top: -35px;

        }

        .logo p {
            margin: 5px 0;
            margin-top: -15px;
            font-size: 18px;
            margin-left: 20px;
            color: white;
        }

        header img {
            margin-top: 10px;
        }

        .navbar {
            background: #ff8d02;
            margin-bottom: 30px;
            margin-top: -30px;
        }

        .navbar ul {
            list-style-type: none;
            padding: 10px;
            display: flex;
            justify-content: flex-end;
            background: #f5d8b5;
            padding-right: 50px;
        }

        .navbar ul li {
            margin-left: 150px;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .navbar ul li img {
            margin-left: 10px;
            margin-bottom: 5px;
            transition: all .5s;
        }

        .navbar ul li img:hover {
            transform: rotate(-90deg);
        }

        .navbar a {
            position: relative;
            text-decoration: none;
        }

        .navbar a::after {
            content: "";
            position: absolute;
            background-color: #ff8d02;
            height: 3px;
            width: 0%;
            transition: 0.3s;
            left: 0;
            bottom: 0px;
            border-radius: 25%;
        }

        .navbar a:hover::after {
            width: 100%;
        }

        .whole#blurr.active {
            filter: blur(20px);
            pointer-events: none;
            user-select: none;
        }

        .boxx {}

        #popup {
            position: fixed;
            top: 20%;
            left: 75%;
            transform: translate(-50%, -50%);
            width: 600px;
            /* padding: 20px; */
            background-color: #f5d8b5;
            visibility: hidden;
            opacity: 0;
            text-align: center;
            border-radius: 20px;
            transition: 0.3s ease;
            /* Use transition here */
        }

        #popup.active {
            top: 25%;
            visibility: visible;
            opacity: 1;
            transition: 0.3s ease;
            /* Use transition here */
        }

        #popup .cbutton {
            color: rgb(255, 255, 255);
            margin-top: 20px;
            padding: 10px 100px;
            background-color: #ff8d02;
            border-radius: 20px;
            font-family: 'Inknut Antiqua', serif;
            /* margin-left: -105px; */
            /* margin-top: 20px; */
            border: none;
        }

        #popup h3 {
            margin: 0;
            padding: 0;
            background-color: #ff8d02;
            margin: 0px 40px 40px 40px;
            border-radius: 0px 0px 10px 10px;
            color: #fff;

        }

        a {
            text-decoration: none;
            color: black;
        }

        .danger {
            background-color: #f5d8b5;
            padding: 5px;
            border-radius: 5px;
            text-align: start;
            display: grid;
            justify-content: center;
            align-items: center;
            /* flex-direction: column; */
        }

        .danger p {
            text-align: center;
            /* background-color: ; */
            margin: 10px;
            /* border-radius: 10px; */
        }

        .boxx-img{

        }
    </style>
</head>

<body>
    <header>
        <img src="../../images/FigmaLogo.svg" height="100px" width="200px">
        <div class="logo">
            <h1>Zero Hunger</h1>
            <p><b>Nourishing Lives, Creating Smiles!</b></p>
        </div>
        <div class="login-logo">
            <img onclick="toggle()" src="../../images/Person-Logo.png" height="50px" width="50px">
        </div>
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="../main-module/index.php">Home <img src="../../images/Arrow-Down.png" height="5px" width="10px"></a></li>
            <li><a href="../main-module/lastestPage.php">Latest<img src="../../images/Arrow-Down.png" height="5px" width="10px"></a></li>
            <li><a href="../main-module/aboutUsPage.php">About Us<img src="../../images/Arrow-Down.png" height="5px" width="10px"></a></li>
        </ul>


    </nav>
    <!-----popup----->

    <div id="popup">
        <h3></h3>
        <div class="danger">
            <h3><?php echo $username; ?></h3>
            <div class="boxx">
                <ul>
                    <li>Profile</li>
                    <li>My Pilanthrpic Footprints</li>
                    <li>Help</li>
                    <li>log Out</li>
                </ul>
            </div>
            <div class="boxx-img">
                <img src="../../images/profile.png" alt="image" height="30px" width="30px">
                <img src="../../images/eye-icon.png" alt="image" height="30px" width="30px">
                <img src="../../images/help.png" alt="image" height="30px" width="30px">
                <img src="../../images/logout.png" alt="image" height="30px" width="30px">
            </div>
        </div>
        <button class="cbutton" onclick="toggle()" type="button"><b>Close</b></button>
    </div>


    <script>
        function toggle() {
            const popup = document.getElementById('popup');
            popup.classList.toggle('active');
        }
    </script>
</body>

</html>