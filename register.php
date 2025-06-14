<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $mobile = htmlspecialchars(trim($_POST['mobile']));

    // Basic validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($mobile)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $error = "Please enter a valid mobile number.";
    } else {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'attireyard');

        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        }

        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO useraccount (firstName, lastName, email, password, mobile) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $firstName, $lastName, $email, $password, $mobile); // Store password as plain text

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecommerce Website</title>
    <link rel="stylesheet" href="style.css">

    <!-- box-icons link -->
    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!-- remix-icons link -->
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"/>

    <!-- google fonts link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>

    <!--- header --->
    <header>
        <a href="index.html" class="logo">AttireYard.co</a>
        <ul class="navlist">
            <li><a href="product.html">All Products</a></li>
            <li><a href="new.html">New Arrivals</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
        
        <div class="nav-right">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Find Product" aria-label="Search">
                <button class="btn1" type="submit">Search</button>
            </form>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>
    
    <section class="regin">
        <div class="user_cred" data-aos="fade-up">
            <h2>Register</h2>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form method="POST" action="register.php">
                <input type="text" name="firstName" placeholder="First Name" required><br>
                <input type="text" name="lastName" placeholder="Last Name" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="text" name="mobile" placeholder="Mobile Number" required><br>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </section>

    <!--- newsletter section --->
    <section class="newsletter">
        <div class="newsletter-content" data-aos="zoom-in">
            <div class="newsletter-text">
                <h2>Get on the List</h2>
                <p>Sign Up with your Email Address to receive Updates</p>
            </div>

            <form action="subscribe.php" method="post">
                <input type="email" placeholder="Your Email..." id="Email" name="Email" required>
                <input type="submit" value="Subscribe" class="btn3">
            </form>
        </div>
    </section>

    <!--- footer --->
    <section class="footer" data-aos="fade-down">
        <div class="footer-box">
            <h3>Company</h3>
            <a href="about.html">About</a>
            <a href="#">Career</a>
        </div>

        <div class="footer-box">
            <h3>FAQ</h3>
            <a href="#">Account</a>
            <a href="#">Features</a>
        </div>

        <div class="footer-box">
            <h3>Resources</h3>
            <a href="#">YouTube Playlist</a>
            <a href="#">Works</a>
        </div>

        <div class="footer-box">
            <h3>Social</h3>
            <div class="social">
                <a href="#"><i class="ri-facebook-fill"></i></a>
                <a href="#"><i class="ri-instagram-fill"></i></a>
                <a href="#"><i class="ri-twitter-x-fill"></i></a>
            </div>
        </div>
    </section>

    <!--- copyright --->
    <div class="copyright">
        <div class="end-text">
            <p>&copy; CopyRight 2024 By AttireYard.co (Ayaan And Yashfin)</p>
        </div>
        
        <div class="end-img">
            <img src="img/p.png">
        </div>
    </div>

    <!--- custom js link --->
    <script src="script.js"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({
        offset: 300,
        duration: 1450,
      });
    </script>

</body>
</html>