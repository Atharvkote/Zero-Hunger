<?php
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
        $showError = "Username already exists!";
    } else {
        // Check if passwords match
        if ($password == $cpassword) {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $sql = "INSERT INTO `users-information` ( `email`, `username`, `password`, `state`, `district`, `pincode`, `date`) VALUES ('$email', '$username', '$password', '$state', '$district', '$pincode', '$current_date');";
            $result = mysqli_query($connection, $sql);

            if ($result) {
                $showAlert = "Sign-up successful!";
                header("Location: loginPage.php");
                exit();
            } else {
                $showError = "Failed to sign up. Please try again.";
            }
        } else {
            $showError = "Passwords do not match!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="createAccount-style.css">
    <script type="text/javascript" src="script.js"></script>
    <title>Zero Hunger - Create Account</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
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
        <!-- Display success alert -->
        <?php if ($showAlert): ?>
            <div class="custom-alert" id="alertBox">
                <?php echo $showAlert; ?>
                <button type="button" class="close-btn" onclick="closeAlert()">×</button>
            </div>
        <?php endif; ?>

        <!-- Display error alert -->
        <?php if ($showError): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $showError; ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <h2>Create Account</h2>
            <div class="subtitle">
                <div class="first"></div>
                <div class="second"></div>
                <div class="third"></div>
                <p><b>Fill Following Details To Create an Account</b></p>
            </div>
            <form action="createAccount.php" method="post">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>

                <label for="cpassword">Confirm Password</label>
                <input type="password" id="cpassword" name="cpassword" placeholder="Enter Password" required>

                <label for="state">State</label>
                <input type="text" id="state" name="state" placeholder="Enter State" required>

                <label for="district">District</label>
                <input type="text" id="district" name="district" placeholder="Enter District" required>

                <label for="pincode">Pincode</label>
                <input type="text" id="pincode" name="pincode" placeholder="Enter Pincode" required>

                <button type="submit"><b>Create Account</b></button>
            </form>
        </div>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>