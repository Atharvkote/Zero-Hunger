<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '../essentails/DataBase-LINK.php';
    $name = $_POST["username"];
    $password = $_POST["password"];

    // Query to fetch the user by username
    $sql = "SELECT * FROM `users-information` WHERE `username` = '$name'";
    $request = mysqli_query($connection, $sql);
    $found = mysqli_num_rows($request);

    if ($found == 1) {
        while ($row = mysqli_fetch_assoc($request)) {
            // Use password_verify to check the hashed password
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $name;
                header("Location: ../main-module/index.html");
                exit(); // Prevent further code execution after redirect
            } else {
                session_start();
                $_SESSION['showError'] = "Invaalid Credentials"; // Incorrect password
            }
        }
    } else {
        session_start();
        $_SESSION['showError'] = "Invalid Credentials [ Username NOT Found ]"; // Username not found
    }

    if (isset($_SESSION['showError'])) {
        header("Location: loginAlert.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login-style.css">
    <title>Zero Hunger - Login In</title>
</head>

<body>
    <?php
        include '../essentails/navbar.html';
    ?>
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
                <button type="submit"><b>Log In</b></button>
            </form>
        </div>
    </div>
</body>

</html>