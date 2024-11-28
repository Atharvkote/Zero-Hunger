<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger</title>
    <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap');
        /* Footer Styles */
        footer {
            background-color: #4d4b4b80;
            color: white;
            padding: 0;
            font-family: "Inknut Antiqua", serif;
        }

        .footer-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 1200px;
            margin: 0 5px 5px 5%;
        }

        .footer-row {

            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 20px;
        }

        .footer-column {
            /* flex: 1; */
            padding: 10px;
            text-align: center;
        }

        .footer-column ul {
            display: flex;
            /* flex-direction: column; */
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            /* Display list items horizontally */
            justify-content: center;
            /* Center align items */
        }

        .footer-column ul li {
            margin: 0 10px;
            /* Space out each link */
        }

        .footer-column a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .footer-column a:hover {
            text-decoration: underline;
        }

        .social-icons {
            text-align: center;
        }

        .social-icons a {
            color: white;
            font-size: 20px;
            margin: 5px;
            text-decoration: none;
        }

        .social-icons a:hover {
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .footer-row {
                flex-direction: column;
                text-align: center;
            }

            .footer-column {
                padding: 5px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Your Main Content Here -->

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <div class="footer-row">
                <!-- Left Section: Copyright -->
                <div class="footer-column">
                    <p>&copy; 2024 Zero Hunger Project. All rights reserved.@Team BYPASS</p>
                </div>
                <!-- Center Section: Links -->
                <div class="footer-column">
                    <ul>
                        <li><a href="../main-module/contactUs.php">Contact</a></li>
                        <li><a href="../assets/privacyPolicy.php">Privacy Policy</a></li>
                        <li><a href="../assets/termandCondition.php">Terms of Service</a></li>
                    </ul>
                </div>
                <!-- Right Section: Social Media Icons -->
                <div class="footer-column social-icons">
                    <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Font Awesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>

</html>