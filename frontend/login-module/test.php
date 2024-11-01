<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '../assets/DataBase-LINK.php';
    $name = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM `users-information` WHERE username = '$name'";
    $request = mysqli_query($connection, $sql);
    $found = mysqli_num_rows($request);

    session_start(); // Start the session at the beginning of the PHP script

    if ($found == 1) {
        $row = mysqli_fetch_assoc($request);
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $name;
            // header("Location: ../main-module/index.html"); // Uncomment this to redirect after successful login
            exit();
        } else {
            $_SESSION['showError'] = "Invalid Credentials"; // Incorrect password
        }
    } else {
        $_SESSION['showError'] = "Invalid Credentials [ Username NOT Found ]"; // Username not found
    }

    header("Location: test.php"); // Redirect back to the login page to show the error
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="test.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">
    <title>Zero Hunger - Login In</title>
</head>

<body>
    <div class="whole" id="blurr">
        <?php
        include '../assets/navbar.html';
        ?>
        <div class="container">

            <!-- Form Container Section -->
            <div class="first"></div>
            <div class="second"></div>
            <div class="third"></div>
            <div class="form-container">
                <h2>Login In</h2>
                <form action="test.php" method="post">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter Username" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    <a href="signupPage.php">
                        <p>Don’t Have an Account? Create Account</p>
                    </a>
                    <button class="sbutton" onclick="toggle()" type="submit"><b>Log In</b></button>
                </form>
            </div>

        </div>
    </div>

    <!-----popup----->

    <div id="popup">
        <H3>Oops! Something went Wrong</H3>
       <?php 
         if (isset($_SESSION['showError'])) {
            echo '<p id="popup-text">' . $_SESSION['showError'] . '</p>';
         }
       ?>
        <button class="cbutton" onclick="toggle()" type="submit"><b>Close</b></button>

    </div>
    <script>
        window.onload = function() {
            <?php if (isset($_SESSION['showError'])): ?>
                toggle(); // Automatically open the popup if there is an error
            <?php endif; ?>
        };
    </script>
    <script src="script.js"></script>
</body>

</html>