<?php
session_start();
// Include PHPMailer files
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/SMTP.php';

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $mobile_number = htmlspecialchars($_POST['mobile-number']);
    $birth_date = htmlspecialchars($_POST['birth-date']);
    $address = htmlspecialchars($_POST['address']);
    
    // Get selected roles
    $roles = [];
    if (isset($_POST['serving-agent'])) $roles[] = "Serving Agent";
    if (isset($_POST['food-collector'])) $roles[] = "Food Collector";
    if (isset($_POST['quality-manager'])) $roles[] = "Quality Manager";
    if (isset($_POST['developer'])) $roles[] = "Developer";
    
    // Combine roles into a string
    $roles = !empty($roles) ? implode(", ", $roles) : 'No roles selected';

    // Prepare the email content
    $to = "atharvkote3@gmail.com"; // Recipient's email
    $subject = "Volunteer Application Submission";

    $message = "
    Dear Zero Hunger Team,

    I am writing to express my interest in becoming a volunteer for your esteemed organization. Below are the details of my application:

    Mobile Number: $mobile_number  
    Birth Date: $birth_date  
    Residential Address:  
    $address  

    I am enthusiastic about contributing to the following roles:  
    $roles  

    I strongly believe in the mission of Zero Hunger and am eager to support its goals. I assure you of my commitment to fulfilling the responsibilities associated with the roles I have selected.  

    Please feel free to contact me at the provided mobile number for further discussions or clarifications.  

    Looking forward to the opportunity to contribute to this noble cause.  

    Sincerely,  
    [Your Name]
    ";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Set up the SMTP server
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Use Gmail's SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $_SESSION['email']; // Your Gmail address
        $mail->Password = 'your-email-password'; // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set email sender and recipient
        $mail->setFrom('your-email@gmail.com', 'Zero Hunger');
        $mail->addAddress($to); // Volunteer email recipient

        // Set email format and subject
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Send the email
        $mail->send();
        echo 'Thank you for your application! An email has been sent, and we will contact you soon.';
    } catch (Exception $e) {
        echo "Failed to send the email. Please try again. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>
