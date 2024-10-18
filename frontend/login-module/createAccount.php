<?php
session_start();
$showError = $showAlert = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../essentails/DataBase-LINK.php';

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $pincode = $_POST['pincode'];
    $current_date = date('Y-m-d');

    // Check if username already exists
    $existSql = "SELECT * FROM `users-information` WHERE username = '$username'";
    $result = mysqli_query($connection, $existSql);
    $numExistRows = mysqli_num_rows($result);

    if ($numExistRows > 0) {
        // Username already exists
        $_SESSION['showError'] = "Username already exists!";
    } else {
        // Check if passwords match
        if ($password == $cpassword) {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $sql = "INSERT INTO `users-information` ( `email`, `username`, `password`, `state`, `district`, `pincode`, `date`) VALUES ('$email', '$username', '$hashed_password', '$state', '$district', '$pincode', '$current_date');";
            $result = mysqli_query($connection, $sql);

            if ($result) {
                $_SESSION['showAlert'] = "Sign-up successful!";
                header("Location: loginPage.php");
                exit();
            } else {
                $_SESSION['showError'] = "Failed to sign up. Please try again.";
            }
        } else {
            $_SESSION['showError'] = "Passwords do not match!";
        }
    }
}
// Displaying alerts if set in the session
if (isset($_SESSION['showAlert'])) {
    $showAlert = $_SESSION['showAlert'];
    unset($_SESSION['showAlert']); // Clear the session variable after use
}

if (isset($_SESSION['showError'])) {
    $showError = $_SESSION['showError'];
    unset($_SESSION['showError']); // Clear the session variable after use
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="createAccount-style.css">
    <title>Zero Hunger - Create Account</title>
</head>

<body>
    <header>
        <img src="../../images/FigmaLogo.svg" height="100px" width="200px">
        <div class="logo">
            <h1>Zero Hunger</h1>
            <p><b>Nourishing Lives, Creating Smiles!</b></p>
        </div>
        <div class="login-logo">
            <a href="../login-module/createAccount.php">
                <img src="../../images/Person-Logo.png" height="50px" width="50px">
            </a>
        </div>
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Latest</a></li>
            <li><a href="#">About Us</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2>Create Account</h2>
            <div class="subtitle">
                <div class="first"></div>
                <div class="second"></div>
                <div class="third"></div>
                <p><b>Fill Following Details To Create an Account</b></p>
            </div>

            <form action="createAccount.php" method="post">
                <!-- Display success alert -->
                <?php
                if (isset($showAlert)) {
                    echo '
                          <div class="alert alert-success" role="alert">
                          ' . $showAlert . '
                          </div>';
                } else if (isset($showError)) {
                    echo '
                          <div class="alert alert-danger" role="alert">
                         ' . $showError . '
                        </div>';
                }
                ?>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" required>

                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter Username" required>

                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    </div>

                    <div class="form-group">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" id="cpassword" name="cpassword" placeholder="Enter Password" required>

                        <label for="state">State</label>
                        <input type="text" id="state" name="state" placeholder="Enter State" required>

                        <label for="district">District</label>
                        <input type="text" id="district" name="district" placeholder="Enter District" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pincode">Pincode</label>
                    <input type="text" id="pincode" name="pincode" placeholder="Enter Pincode" required>
                </div>

                <button type="submit"><b>Create Account</b></button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
