<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Zero Hunger - Contact US</title>
    <link rel="stylesheet" href="contactUs-style.css">
    <link rel="icon" href="../../images/Zero-Hunger-Favicon.png" type="image/icon type">
    <!-- Font Awesome CDN Link -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <script src="reportIssue.js"></script>

    </style>
</head>

<body>
    <?php include '../assets/navbar.php'; ?>
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
                <p>If you have any work or queries related to our project, feel free to send a message here. We would be happy to help you.</p>
                <form id="contactForm">
                    <div class="input-box">
                        <input type="text" id="name" name="name" placeholder="Enter your name" aria-label="Name" required>
                    </div>
                    <div class="input-box">
                        <input type="email" id="email" name="email" placeholder="Enter your email" aria-label="Email" required>
                    </div>
                    <div class="input-box message-box">
                        <textarea id="message" name="message" placeholder="Enter your message" aria-label="Message" required></textarea>
                    </div>
                    <div class="button">
                        <input type="submit" value="Send Now">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Attaching the event listener to handle form submission
        document.getElementById("contactForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevents the form from submitting the traditional way

            console.log("Form submitted"); // Logging to verify function execution

            // Collect form data
            let parameters = {
                name: document.getElementById("name").value,
                email: document.getElementById("email").value,
                message: document.getElementById("message").value
            };

            console.log("Parameters: ", parameters); // Logging parameters to verify values

            // Send the email
            emailjs.send("service_e8hjt14", "template_jcwqc78", parameters).then(alert("email sent"))

        });
    </script>
</body>

</html>