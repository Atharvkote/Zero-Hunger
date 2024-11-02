<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login-module/loginPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Hunger - About Us</title>
    <link rel="stylesheet" href="aboutUs.css">
    <link rel="icon" href="../../images/Red-Heart-Logo.png" type="image/icon type">
</head>

<body>
    <?php
    include '../assets/navbar.php';  // import navbar as a componenet 
    ?>
    <div class="head">
        <h1>Zero Hunger By Team BYPAS07!</h1>
    </div>
    <div class="top">
        <p> <span class="highlight">The team BYPAS07 is a dynamic group of five second-year Software Engineering students </span> by a shared mission to make a positive social impact through technology. Working on the Zero Hunger project, the team is developing an innovative web application that facilitates the collection and distribution of food to those in need. <span class="highlight">By connecting donors who have surplus food with individuals and communities facing hunger, BYPAS07 aims to reduce food waste and address food insecurity effectively</span>.</p>
        <p>Each member contributes unique skills in areas like frontend design, backend development, database management, and user experience to create a platform that ensures excess resources<span class="highlight"> reach the people who need them most</span>, fostering a more sustainable and equitable community.</p>
    </div>
    <h2>Our Values</h2>
    <div class="values">
        <img src="../../images/Values.png" height="300px" width="350px" alt="" srcset="">
        <ul>
            <li><strong>Innovation:</strong> We embrace new ideas and technologies to stay ahead of the curve.</li>
            <li><strong>Collaboration:</strong> We believe in the power of teamwork and open communication.</li>
            <li><strong>Quality:</strong> We are committed to delivering the highest quality products and services.</li>
            <li><strong>Customer Satisfaction:</strong> Our clients are at the heart of everything we do.</li>
        </ul>
    </div>
    <h2>Meet Our Team</h2>

    <div class="team-member">
        <h3><img src="../../images/Person-Logo.png" alt="image" height="30px" width="30px">Atharva Kote</h3>
        <p><strong>Role:</strong> Lead Developer</p>
        <p><strong>Bio:</strong> With over 8 years of experience in full-stack development,Atharva specializes in building scalable web applications. His passion for coding started at a young age, and she loves tackling complex challenges head-on.</p>
        <div class="social-links">
            <span class="linkedin"><a target="_blank" href="https://www.linkedin.com/in/atharvakote"><img src="../../images/LinkedIn.png" height="25px" width="25px" alt="linkedin">LinkedIn</a></span>
            <span class="github"> <a target="_blank" href="https://github.com/Atharvkote/"><img src="../../images/Github.png" height="25px" width="25px" alt="linkedin">Github</a></span>
        </div>
    </div>

    <div class="team-member">
        <h3><img src="../../images/Person-Logo.png" alt="image" height="30px" width="30px">Bhushan Korde</h3>
        <p><strong>Role:</strong> UI/UX Designer / Prototyper</p>
        <p><strong>Bio:</strong> Bhushan is a creative designer with a knack for crafting intuitive user experiences. He believes that design should not only be beautiful but also functional.</p>
        <div class="social-links">
            <span class="linkedin"><a target="_blank" href="https://www.linkedin.com/in/bhushan-korde-4890a6288/"><img src="../../images/LinkedIn.png" height="25px" width="25px" alt="linkedin">LinkedIn</a></span>
            <span class="github"><a target="_blank" href="https://github.com/BhushanKorde/"><img src="../../images/Github.png" height="25px" width="25px" alt="linkedin">Github</a></span>
        </div>
    </div>

    <div class="team-member">
        <h3><img src="../../images/Person-Logo.png" alt="image" height="30px" width="30px">Pranav Mule</h3>
        <p><strong>Role:</strong> React Expert / Front-End Developer</p>
        <p><strong>Bio:</strong> Pranav is a front-end wizard who transforms designs into responsive, interactive websites. With a strong foundation in HTML, CSS, and JavaScript, she is always exploring the latest trends in front-end development.</p>
        <div class="social-links">
            <span class="linkedin"><a target="_blank" href="https://www.linkedin.com/in/pranav-mulay-29a133288?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"><img src="../../images/LinkedIn.png" height="25px" width="25px" alt="linkedin">LinkedIn</a></span>
            <span class="github"><a target="_blank" href="https://github.com/pranavmulay18/"><img src="../../images/Github.png" height="25px" width="25px" alt="linkedin">Github</a></span>
        </div>
    </div>

    <div class="team-member">
        <h3><img src="../../images/Person-Logo.png" alt="image" height="30px" width="30px">Sairaj Naikwade</h3>
        <p><strong>Role:</strong> Back-End Developer / Node.js Expertise</p>
        <p><strong>Bio:</strong> Sairaj is a back-end specialist with a passion for building robust server-side applications. His expertise in databases and APIs ensures that our projects run smoothly and efficiently.</p>
        <div class="social-links">
            <span class="linkedin"><a target="_blank" href="https://www.linkedin.com/in/sairaj-naikwade-08a223283?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"><img src="../../images/LinkedIn.png" height="25px" width="25px" alt="linkedin">LinkedIn</a></span>
            <span class="github"><a target="_blank" href="https://github.com/sairajnaikwade"><img src="../../images/Github.png" height="25px" width="25px" alt="linkedin">Github</a></span>
        </div>
    </div>

    <div class="team-member">
        <h3><img src="../../images/Person-Logo.png" alt="image" height="30px" width="30px">Yash Nannaware</h3>
        <p><strong>Role:</strong> Databae Manager / SQL expertise</p>
        <p><strong>Bio:</strong> Yash is the glue that holds our team together. With his exceptional organizational skills and attention to detail, he ensures that projects are delivered on time and within budget.</p>
        <div class="social-links">
            <span class="linkedin"><a target="_blank" href="#"><img src="../../images/LinkedIn.png" height="25px" width="25px" alt="linkedin">LinkedIn</a></span>
            <span class="github"><a target="_blank" href="#"><img src="../../images/Github.png" height="25px" width="25px" alt="linkedin">Github</a></span>
        </div>
    </div>

    <div class="two-button">
        <a href="../volunteer-module/volunteer.php">
            <p>Join Us on Our Journey</p>
        </a>
        <a href="contactUs.php">
            <p>Contact Us</p>
        </a>
    </div>
    <div class="bottom">
        <p>We are always looking for new challenges and opportunities to grow. If you're interested in working with us, feel free to reach out!</p>
        <h3>Let’s create something amazing together!</h3>
    </div>

</body>

</html>