<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '../assets/DataBase-LINK.php';
    $name = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM `users-information` WHERE username = '$name'";
    $request = mysqli_query($connection, $sql);
    $found = mysqli_num_rows($request);
    // echo "Found rows: $found";                                                    // DE-BUGGER

    if ($found == 1) {
        $row = mysqli_fetch_assoc($request);
        // if (password_verify($password, $row['password'])) {
        //     echo "Password verified!";
        // } else {                                                     // DE-BUGGER
        //     echo "Password not verified!";
        // }
        echo $row['password'];
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $name;
            header("Location: ../main-module/index.php");
            exit();
        } else {
            $_SESSION['showError'] = "Invalid Credentials"; // Incorrect password
        }
    } else {
        $_SESSION['showError'] = "Invalid Credentials [ Username NOT Found ]"; // Username not found
    }

    header("Location: loginPage.php"); // Redirect back to the login page to show the error
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login-style.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">
    <title>Zero Hunger - Login In</title>
</head>
<body>
    <div class="whole" id="blurr">
        <?php include '../assets/navbar.html'; ?>
        <div class="container">
            <!-- Form Container Section -->
            <div class="first"></div>
            <div class="second"></div>
            <div class="third"></div>
            <div class="form-container">
                <h2>Login In</h2>
                <form action="loginPage.php" method="post">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter Username" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    <a href="signupPage.php">
                        <p>Don’t Have an Account? Create Account</p>
                    </a>
                    <button class="sbutton" type="submit"><b>Log In</b></button>
                </form>
            </div>
        </div>
    </div>

    <!-----popup----->

    <div id="popup">
        <h3>Oops! Something went Wrong</h3>
        <div class="danger">
            <?php
            if (isset($_SESSION['showError'])) {
                echo '<p id="popup-text">' . $_SESSION['showError'] . '</p>';
                echo '
                <ul>
                    <li>Check You Have Account with this Username</li>
                    <li>Check Password You Entered Correct Or NOT</li>
                    <li>Check Casing of the Letter or Any Special Symbol</li>
                </ul>';
            }
            ?>
        </div>
        <button class="cbutton" onclick="toggle()" type="button"><b>Close</b></button>
    </div>

    <script>
        window.onload = function() {
            <?php if (isset($_SESSION['showError'])): ?>
                toggle(); // Open the popup if there is an error
                <?php unset($_SESSION['showError']); // Clear the error after opening ?>
            <?php endif; ?>
        };

        function toggle() {
            const blurr = document.getElementById('blurr');
            blurr.classList.toggle('active');

            const popup = document.getElementById('popup');
            popup.classList.toggle('active');
        }
    </script>
    <script src="popUpToggler.js"></script>
</body>
</html>
