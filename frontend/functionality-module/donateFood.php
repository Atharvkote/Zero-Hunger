<?php
session_start();
$showError = $showAlert = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../assets/DataBase-LINK.php';
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `users-information` WHERE username = '$username'";
    $request = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($request);                        // since Username is Unique
    
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    
    $landmark = $_POST['landmark'];
    $day= $_POST['day'];
    $time = time();
    $message = $_POST['message'];
   
    $item_name_1 = $_POST['item-1'];
    $qty_1 = $_POST['qty-1'];
    $freshly_made_1 = isset($_POST['freshly-made-1']) ? 1 : 0;
    
    $item_name_2 = $_POST['item-2'];
    $qty_2 = $_POST['qty-2'];
    $freshly_made_2 = isset($_POST['freshly-made-2']) ? 1 : 0;
    
    $item_name_3 = $_POST['item-3'];
    $qty_3 = $_POST['qty-3'];
    $freshly_made_3 = isset($_POST['freshly-made-3']) ? 1 : 0;
    
    $item_name_4 = $_POST['item-4'];
    $qty_4 = $_POST['qty-4'];
    $freshly_made_4 = isset($_POST['freshly-made-4']) ? 1 : 0;
    
    $item_name_5 = $_POST['item-5'];
    $qty_5 = $_POST['qty-5'];
    $freshly_made_5 = isset($_POST['freshly-made-5']) ? 1 : 0;

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - Donate Food</title>
    <link rel="stylesheet" href="donate-Food.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">

</head>

<body>
    <?php
         include '../assets/navbar.php';  // import navbar as a componenet 
    ?>
    <div class="container">
        <div class="left-column">
            <form action="donateFood.php" method="post">
                <div class="section-title">Donate Food</div>
                <div class="upper">
                    <div class="form-group">
                        <label>Enter Your Residence Address/Landmark Name</label>
                        <input name="landmark" placeholder="Enter name of your shop or mess or a hotel if not mention nearest landmark" type="text" />
                    </div>
                    <div class="form-group">
                        <label>Mention Day Food was Made</label>
                        <input  name="day" placeholder="Enter day food was made" type="date" />

                    </div>
                    <div class="form-group">
                        <label>Message for Reciever - Type something special</label>
                        <textarea name="message" placeholder="Message for the receiver"></textarea>
                    </div>
                    <button class="location-button">
                        <span>Add My Current Location</span>
                        <img class="location-icon" src="../../images/Location.png" alt="location" />
                    </button>
                </div>
                <div class="section-title">Food Details</div>
                <div class="food-details">
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input name="item-1" placeholder="Enter name of food" type="text" required>
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-1" placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-1" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input  name="item-2" placeholder="Enter name of food" type="text" />
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-2" placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-2" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input  name="item-3" placeholder="Enter name of food" type="text" />
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-3"  placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-3" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input  name="item-4" placeholder="Enter name of food" type="text" />
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-4"  placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-4" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="name">
                            <label>Name</label>
                            <input  name="item-5" placeholder="Enter name of food" type="text" />
                            <label><i>( Type of Food )</i></label>
                        </div>
                        <div class="qty">
                            <label>Quantity</label>
                            <input name="qty-5" placeholder="QTY" type="number" />
                            <label>0-100 kg</label>
                        </div>
                        <div class="radioo">
                            <label class="yes">Yes</label>
                            <input name="freshly-made-5" type="radio" />
                            <label>Freshly Made</label>
                        </div>
                    </div>
                </div>
           
        </div>
        <div class="right-panel">
            <div class="image-placeholder"></div>
            <div class="option">
                <button class="btn">Add Visuals <img src="../../images/Camera.png" alt="location" /></button>
                <button class="btn">From Gallery <img src="../../images/Photo.png" alt="location" /></i></button>
                <button class="btn">Add Video <img src="../../images/Video.png" alt="location" /></button>
            </div>

            <div class="message">
                <img src="../../images/Red-Heart-Logo.png" alt="red" class="red" height="100px" width="100px">
                <p>You doing a great work !!!</p>
                <p>Putting a step toward mutual group of human care worldwide</p>
            </div>
            <div class="foooter">
                <p class="warning">
                    If any type of malpractices found (fake or duplicate entry) will be banned from the website.
                </p>
                <input class="submit-button" type="submit" value="Submit" />
            </div>
        </div>
    </div>
    </div>
    </form>
    </div>
</body>

</html>