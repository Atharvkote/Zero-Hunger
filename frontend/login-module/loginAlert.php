<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Warning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Center the alert vertically and horizontally */
        .centered-alert {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 600px; /* Optional: limit the maximum width */
        }
    </style>
</head>
<body>

    <?php
    session_start();
    if (isset($_SESSION['showError'])) {
        echo ' 
        <div class="centered-alert">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Oops!</h4>
                <p>' . $_SESSION['showError'] . '</p>
                <hr>
                <p class="mb-0">Please try again or contact support if the issue persists.</p>
                <a href="loginPage.php" class="btn btn-primary mt-3">Back to Login</a>
            </div>
        </div>';
        unset($_SESSION['showError']); // Clear the session error after displaying
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
