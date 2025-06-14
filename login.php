<?php
session_start(); // Start the session

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'attireyard');

    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    // Get the email and password from the form
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Prepare the statement to fetch user data
    $stmt = $conn->prepare("SELECT id, password FROM useraccount WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $storedPassword);
        $stmt->fetch();

        // Verify the password
        if ($password === $storedPassword) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user_id;
            header("Location: profile.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }

    $stmt->close();
    $conn->close();
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
            <a href="cart.html"><i class="ri-shopping-cart-line"></i></a>
            <a href="login.php"><i class="ri-user-line"></i></a>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>

    <section class="regin">
        <div class="user_cred" data-aos="fade-up">
            <h2>Login</h2>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form method="POST" action="login.php">
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
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