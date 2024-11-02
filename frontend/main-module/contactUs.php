<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Zero Hunger - Contact US</title>
    <link rel="stylesheet" href="contactUs-style.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php
      include '../assets/navbar.php';  // import navbar as a componenet 
    ?>
    <div class="container">
        <div class="content">
            <div class="left-side">
                <div class="email details">
                    <i class="fas fa-envelope"></i>
                    <div class="topic">Email</div>
                    <div class="text-one"><a href="mailto:atharvakote81@gmail.com">atharvakote81@gmail.com</a></div>
                    <div class="text-two"><a href="mailto:kordebhushan6120@gmail.com">kordebhushan6120@gmail.com</a></div>
                    <div class="text-two"><a href="mailto:naikwadesairaj@gmail.com">naikwadesairaj@gmail.com</a></div>
                    <div class="text-two"><a href="mailto:pranavmulay2005@gmail.com">pranavmulay2005@gmail.com</a></div>
                    <div class="text-two"><a href="mailto:nannawareyash@gmail.com">nannwareyash@gmail.com</a></div>
                </div>
            </div>
            <div class="right-side">
                <div class="topic-text">Send us a message</div>
                <p>If you have any work or queries related to my tutorial, feel free to send a message here. I would be happy to help you.</p>
                <form action="contact_process.php" method="POST">
                    <div class="input-box">
                        <input type="text" name="name" placeholder="Enter your name" aria-label="Name" required>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" placeholder="Enter your email" aria-label="Email" required>
                    </div>
                    <div class="input-box message-box">
                        <textarea name="message" placeholder="Enter your message" aria-label="Message" required></textarea>
                    </div>
                    <div class="button">
                        <input type="submit" value="Send Now">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
