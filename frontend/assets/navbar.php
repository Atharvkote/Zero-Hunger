<?php
// session_start();
if (isset($_SESSION['username'])  || isset($_SESSION['loggedin'])) {
    $username = $_SESSION['username'];
}
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

        #popup {
            position: fixed;
            top: 35%;
            left: 80%;
            z-index: 9999;
            transform: translate(-50%, -50%);
            width: 400px;
            /* padding: 20px; */
            background-color: #f5d8b5;
            visibility: hidden;
            opacity: 0;
            border: 2px solid #ff8d02;
            text-align: center;
            border-radius: 20px;
            transition: 0.3s ease;
            /* Use transition here */
        }

        #popup.active {
            top: 38%;
            visibility: visible;
            opacity: 1;
            padding: 30px;
            transition: 0.3s ease;
            /* Use transition here */
        }

        #popup .cbutton {
            color: rgb(255, 255, 255);
            margin-top: 20px;
            padding: 5px 100px;
            background-color: #ff8d02;
            border-radius: 20px;
            font-family: 'Inknut Antiqua', serif;
            /* margin-left: -105px; */
            /* margin-top: 20px; */
            border: none;
            font-size: 20px;
            transition: .3s ease;
        }

        #popup .cbutton:hover {
            transform: scale(1.05);
        }

        #popup h2 {
            /* background-color: #ff8d02; */
            margin: 0px 0px 0px 0px;
            border-radius: 0px 0px 10px 10px;
            color: black;

        }

        a {
            text-decoration: none;
            color: black;
        }

        .danger-new {
            background-color: #f5d8b5;
            padding: 5px;
            border-radius: 5px;
            text-align: start;
            display: flex;
            justify-content: center;
            align-items: center;
            /* flex-direction: column; */
        }

        .danger-new p {
            text-align: center;
            /* background-color: ; */
            margin: 10px;
            /* border-radius: 10px; */
        }

        .danger-new ul li img {
            margin-right: 40px;
        }

        .danger-new ul {
            display: flex;
            justify-content: flex-start;
            flex-direction: column;
            width: 100%;
            padding: 0;
        }

        .danger-new ul li {
            list-style: none;
            width: 100%;
            font-size: larger;
            display: flex;
            align-items: center;
            flex-direction: row;
            background-color: #f5d8b5;
            border-radius: 10px;
            transition: .3s ease;
            border-radius: 5px;
            padding-left: 20px;
        }

        .user-info {
            display: flex;
            justify-content: left;
            align-items: center;
            gap: 30px;
        }

        .user-info img {
            width: 50px;
            height: 50px;
        }

        hr {
            border: 1px solid #ff8d02;
            border-radius: 30%;

        }

        .danger-new ul li:hover {
            transform: scale(1.05);
            background-color: #ff8d02;
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
            <img onclick="toggleNavbarPopup()" src="../../images/Person-Logo.png" height="50px" width="50px">
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

        <div class="user-info">
            <img src="../../images/Person-Logo.png" alt="user" height="30px" width="30px">
            <h2><?php echo $username; ?></h2>
        </div>
        <hr />
        <div class="danger-new">
            <ul>
                <a href="../user-module/profilePage.php">
                    <li><img src="../../images/profile.png" alt="image" height="30px" width="30px">Profile</li>
                </a>
                <a href="#">
                    <li><img src="../../images/eye-icon.png" alt="image" height="30px" width="30px">My Pilanthrpic Footprints</li>
                </a>
                <a href="../main-module/contactUs.php">
                    <li><img src="../../images/help.png" alt="image" height="30px" width="30px">Help</li>
                </a>
                <a href="../login-module/logout.php">
                    <li><img src="../../images/logout.png" alt="image" height="30px" width="30px">Log Out</li>
                </a>
            </ul>
        </div>
        <button class="cbutton" onclick="toggleNavbarPopup()" type="button"><b>Close</b></button>
    </div>
    <script>
        function toggleNavbarPopup() {
            <?php if (isset($_SESSION['username']) || isset($_SESSION['loggedin'])): ?>
                const popup = document.getElementById('popup');
            popup.classList.toggle('active');
        <?php endif; ?>
        }
    </script>
</body>

</html>