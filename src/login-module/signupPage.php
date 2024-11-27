<?php
session_start();
$showError = $showAlert = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../assets/DataBase-LINK.php';

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $current_date = date('Y-m-d');

    // Check if username already exists
    $existSql = "SELECT * FROM `users-information` WHERE username = '$username'";
    $result = mysqli_query($connection, $existSql);
    $numExistRows = mysqli_num_rows($result);

    if ($numExistRows > 0) {
        // Username already exists
        $_SESSION['showError'] = "Username already exists! Try Any Other Username!";
    } else {
        // Check if passwords match
        if ($password == $cpassword) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Insert into database with hashed password
            $sql = "INSERT INTO `users-information` (`email`, `username`, `password`, `state`, `district`,`city`, `pincode`, `date`) VALUES ('$email', '$username', '$hashed_password', '$state', '$district','$city', '$pincode', '$current_date')";
            $result = mysqli_query($connection, $sql);
            // echo "Hashed Password at Signup: " . $hashed_password;                             // DE-BUGGER

            if ($result) {
                $_SESSION['showAlert'] = "Sign-up successful!";
            } else {
                $_SESSION['showError'] = "Failed to sign up. Please try again.";
            }
        } else {
            $_SESSION['showError'] = "Passwords do not match!";
        }
    }
    header("Location: signupPage.php");
    exit();
}

// // Displaying alerts if set in the session
// if (isset($_SESSION['showAlert'])) {
//     $showAlert = $_SESSION['showAlert'];
//     unset($_SESSION['showAlert']); // Clear the session variable after use
// }

// if (isset($_SESSION['showError'])) {
//     $showError = $_SESSION['showError'];
//     unset($_SESSION['showError']); // Clear the session variable after use
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - Create Account</title>
    <link rel="stylesheet" href="signup-style.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">
    <script src="passwordValidator.js" defer></script> <!-- Link to external JS file -->
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
    </script>
    <script type="text/javascript">
        (function() {
            emailjs.init({
                publicKey: "_OP9I50wepz2eyb55",
            });
        })();
    </script>
    <script src="EmailSender.js"></script>
</head>

<body>

    <div class="whole" id=blurr>
        <?php include '../assets/static-navbar.php'; ?>

        <div class="form-header">Create Account</div>
        <div class="main">
            <div class="container-new">
                <form action="signupPage.php" method="post" onsubmit="return validatePassword()">
                    <div class="design">
                        <div class="one"></div>
                        <div class="two"></div>
                        <div class="three"></div>
                        <div class="four"></div>
                        <div class="form-container-new">
                            <div class="form-subheader">Enter Following Details To Create Account</div>
                            <div class="form-group-container">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" placeholder="Enter Email" type="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" name="username" placeholder="Enter Username" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" name="password" placeholder="Enter Password" type="password" required>
                                    <div id="password-message"></div> <!-- Message for password validation -->
                                </div>
                                <div class="form-group">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input id="confirm-password" name="cpassword" placeholder="Confirm Password" type="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input id="state" name="state" placeholder="Enter State" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="district">District</label>
                                    <input id="district" name="district" placeholder="Enter District" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="pincode">City/Taluka</label>
                                    <input id="pincode" name="city" placeholder="Enter City/Taluka" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input id="pincode" name="pincode" placeholder="Enter Pincode" type="text" required>
                                </div>
                            </div>
                            <div class="form-button">
                                <button onclick="sendmails()" type="submit">Create Account</button>
                            </div>
                </form>
            </div>
        </div>
    </div>
    <div class="welcome">
        <img src="../../images/Zero-Hunger-Logo.png" alt="img" height="100px" width="100px">
        <h2 class="h2-h">Welcome! To Zero Hunger!</h2>
        <p>Thank you for joining our community dedicated to fighting hunger and reducing food waste. Together, we’re making a difference by connecting donors with surplus food to those in need. Whether you're here to donate, volunteer, or seek resources, we're excited to have you with us!</p>
        <p>Get started by exploring our platform, connecting with others, and contributing to this mission. Every action counts, and together</p>
        <h2 class="fooooter">Let’s make a positive impact!</h2>
    </div>
    </div>
    </div>


    <!-----popup----->

    <div id="popup">
        <h3>Oops! Something went Wrong</h3>
        <?php
        if (isset($_SESSION['showError'])) {
            echo '
                 <div class="danger">
                <p id="popup-text">' . $_SESSION['showError'] . '</p>
                <ul>
                    <li>Check You Have Account with this Username</li>
                    <li>Check Password You Entered Correct Or NOT</li>
                    <li>Check Casing of the Letter or Any Special Symbol</li>
                </ul>
                <button class="cbutton" onclick="toggleInsignPage()" type="button"><b>Close</b></button>
                </div>
                ';
        }
        ?>
        <?php
        if (isset($_SESSION['showAlert'])) {
            echo '
                <div class="success">
                <p id="popup-text">' . $_SESSION['showAlert'] . '</p>
                <p>Accout Created Successfully, Please Login And start Your Journey with Zero Hunger </p>
                <button class="cbutton" onclick="redirect()" type="button"><b>Log In</b></button>
                </div>
                ';
        }
        ?>
    </div>
    <script>
        window.onload = function() {
            <?php if (isset($_SESSION['showError'])): ?>
                toggleInsignPage(); // Open the popup if there is an error
                <?php unset($_SESSION['showError']); // Clear the error after opening 
                ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['showAlert'])): ?>
                toggleInsignPage(); // Open the popup if there is an error
                <?php unset($_SESSION['showAlert']); // Clear the error after opening 
                ?>
            <?php endif; ?>
        };

        function toggleInsignPage() {
            const blurr = document.getElementById('blurr');
            blurr.classList.toggle('active');

            const popup = document.getElementById('popup');
            popup.classList.toggle('active');
        }

        function redirect() {
            window.location.href = "loginPage.php";
        }
    </script>

</body>

</html>