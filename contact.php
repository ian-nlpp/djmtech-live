<?php
session_start();
require 'vendor/autoload.php'; // PHPMailer
include 'db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Server-side validation
    if (empty($fullName) || empty($email) || empty($phone) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (!preg_match('/^09\d{9}$/', $phone)) {
        $error = "Phone number must start with '09' and be 11 digits long.";
    } elseif (strlen($message) > 1000) {
        $error = "Message must not exceed 1000 characters.";
    } else {
        // Store in database
        $stmt = $pdo->prepare("INSERT INTO tbl_contact (full_name, email, phone, message, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$fullName, $email, $phone, $message]);

        // Send email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'djmtech2025@gmail.com'; // Your Gmail
            $mail->Password = 'zvst tjms gxhf agan';    // Your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('djmtech2025@gmail.com', 'DJM Tech');
            $mail->addAddress($email); // Sender as primary recipient
            $mail->addBCC('djmtech2025@gmail.com'); // You as BCC

            $mail->isHTML(true);
            $mail->Subject = 'DJM Tech - Message from ' . htmlspecialchars($fullName);

            // Pre-templated HTML email body
            $mail->Body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: "Poppins", sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(90deg, rgb(112, 0, 255), rgb(160, 0, 255)); color: white; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 600; }
        .content { padding: 20px; }
        .content p { line-height: 1.6; color: #333; }
        .details { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 15px; }
        .details strong { color: rgb(112, 0, 255); }
        .footer { background: #333; color: white; text-align: center; padding: 10px; font-size: 12px; }
        a { color: rgb(112, 0, 255); text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Contacting DJM Tech!</h1>
        </div>
        <div class="content">
            <p>Hi ' . htmlspecialchars($fullName) . ',</p>
            <p>We’ve received your message, and our team is excited to assist you! Here’s what you sent us:</p>
            <div class="details">
                <p><strong>Name:</strong> ' . htmlspecialchars($fullName) . '</p>
                <p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>
                <p><strong>Phone:</strong> ' . htmlspecialchars($phone) . '</p>
                <p><strong>Message:</strong><br>' . nl2br(htmlspecialchars($message)) . '</p>
            </div>
            <p>We’ll get back to you soon—stay tuned!</p>
            <p>Best regards,<br>The DJM Tech Team</p>
        </div>
        <div class="footer">
            <p>© 2025 DJM Tech | <a href="/djmtech">Visit Us</a></p>
        </div>
    </div>
</body>
</html>';

            $mail->AltBody = "Hi " . htmlspecialchars($fullName) . ",\n\nThank you for reaching out! Here’s a copy of your message:\n\n" .
                             "Name: " . htmlspecialchars($fullName) . "\n" .
                             "Email: " . htmlspecialchars($email) . "\n" .
                             "Phone: " . htmlspecialchars($phone) . "\n" .
                             "Message:\n" . htmlspecialchars($message) . "\n\n" .
                             "We’ll get back to you soon!\n\nBest regards,\nDJM Tech Team";

            $mail->send();
            $success = true;
        } catch (Exception $e) {
            $error = "Failed to send your message. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/png" href="assets/icons/favicon.png">
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/contact.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <title>Contact Us</title>
</head>

<body>
    <header class="head">
        <div class="left-side-button">
            <div class="logo"><img src="assets/DJMLogo.png"></div>
            <div class="hamburger" onclick="toggleMenu()">
                <i class='bx bx-menu'></i>
            </div>
            <nav class="navbar" id="nav-menu">
              <a href="index.html">Home</a>
              <a href="products.php">Products</a>
              <a href="about.html">About</a>
              <a href="contact.php" id="indicator">Contact</a>
            </nav>
            <div class="search-bar">
                <input type="text" placeholder="search" />
                <a href="#"><i class="bx bx-search"></i></a>
              </div>
        </div>
        <div class="right-side-button">
          <div class="wishlist-btn">
            <a href="wishlist.php"><i class="bx bx-heart"></i></a>
          </div>
          <div class="cart-btn">
            <a href="cart.php"><i class="bx bxs-cart"></i></a>
            <div class="notification">0</div>
          </div>
          <div class="login-buttons">
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
              <a href="dashboard.php"><i class="bx bxs-user"></i></a>
            <?php else: ?>
              <a href="login.html"><i class="bx bxs-user"></i></a>
            <?php endif; ?>
          </div>
        </div>
    </header>

    <main class="main-content">
      <section class="contact-container">
          <!-- Left Side: Contact Details & Map -->
          <div class="contact-info">
              <h1 class="get-in-touch">GET IN <span class="touch">TOUCH</span></h1>
              <p class="contact-description">
                  Not sure what you need? The team at DJTech will be happy to listen to you!
              </p>
              <div class="contact-details">
                <p><img src="assets/icons/location.png" alt="Location Icon"> <strong>Location:</strong> One Global Place, 5th Avenue, Taguig City, 1634 Metro Manila, Philippines</p>
                <p><img src="assets/icons/email.png" alt="Email Icon"> <strong>Email:</strong> djtech@gmail.com</p>
                <p><img src="assets/icons/phone.png" alt="Phone Icon"> <strong>Phone:</strong> (+63) 907-157-352</p>
              </div>
              <div class="map-container">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1930.216322982854!2d121.04554437762007!3d14.551528780918925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c90d6fd38c23%3A0x79a6a26d4c74c953!2sOne%20Global%20Place!5e0!3m2!1sen!2sph!4v1700000000000!5m2!1sen!2sph" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              </div>
          </div>
  
          <!-- Right Side: Contact Form -->
          <div class="contact-form-container">
              <?php if ($error): ?>
                  <div style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars($error); ?></div>
              <?php endif; ?>
              <?php if ($success): ?>
                  <div style="color: #28a745; margin-bottom: 20px; text-align: center; font-size: 1.2rem;">
                      🎉 Woohoo! Your message has been sent successfully! We’ll get back to you soon!<br>
                      <a href="products.php" class="submit-btn" style="display: inline-block; margin-top: 15px; text-decoration: none;">Shop Again</a>
                  </div>
              <?php else: ?>
                  <p class="form-title">We’d love to hear from you! Let’s get in touch</p>
                  <div id="errorMessages" style="color: red; margin-bottom: 10px; display: none;">
                      <ul id="errorList"></ul>
                  </div>
                  <form id="contactForm" class="contact-form" method="POST">
                      <input type="text" name="fullName" id="fullName" placeholder="Full Name" required>
                      <input type="email" name="email" id="email" placeholder="Email Address" required>
                      <input type="tel" name="phone" id="phone" placeholder="Phone Number" maxlength="11" required>
                      <textarea name="message" id="message" placeholder="Your Message" maxlength="1000" required></textarea>
                      <button type="submit" class="submit-btn">SUBMIT</button>
                  </form>
              <?php endif; ?>
          </div>
      </section>
    </main>
  
    <footer>  
    <div class="upperfooter">
        <div class="column footlogo">
            <div class="logofooter"><img src="assets/DJMLogo.png"></div>
            <div class="djmtagline">
            <p>“DJMTech – Empowering You with the Latest Technology.”</p>
            </div>
        </div>
        <div class="column">
            <h1>Quick</h1>
            <a href="index.html">Home</a>
            <a href="about.html">About Us</a>
            <a href="contact.html">Contact Us</a>
        </div>
        <div class="column">
            <h1>Menu</h1>
            <a href="index.html">Home</a>
            <a href="#">Product</a>
        </div>
    </div>

    <!-- Ensure the <hr> is on a new line -->
    <div class="footer-divider">
        <hr>
    </div>

    <div class="bottom-footer">
        <div class="layout">
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" class="logoContainer">
                    <img src="assets/icons/facebook.png" alt="Facebook">
                </a>
                <a href="https://instagram.com" target="_blank" class="logoContainer">
                    <img src="assets/icons/instagram.png" alt="Instagram">
                </a>
                <a href="https://twitter.com" target="_blank" class="logoContainer">
                    <img src="assets/icons/twitter.png" alt="Twitter">
                </a>
            </div>
            <p>&copy; 2025 By Lintech Inc. All Rights Reserved. 
                <a href="terms-of-use.html">Terms of Use</a> <a href="privacy-policy.html">Privacy Policy</a>
            </p>
        </div>
    </div>
    
    
    </div>
    </footer>

    <?php if (!$success): ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('contactForm');

            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    clearErrors();

                    const fullName = document.getElementById('fullName').value.trim();
                    const email = document.getElementById('email').value.trim();
                    const phone = document.getElementById('phone').value.trim();
                    const message = document.getElementById('message').value.trim();

                    let hasError = false;
                    const errorMessages = [];
                    if (fullName === "") { errorMessages.push("Full name is required."); hasError = true; }
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (email === "" || !emailPattern.test(email)) { errorMessages.push("Please enter a valid email address."); hasError = true; }
                    const phonePattern = /^09\d{9}$/;
                    if (phone === "" || !phonePattern.test(phone)) { errorMessages.push("Phone number must start with '09' and be 11 digits long."); hasError = true; }
                    if (message === "") { errorMessages.push("Message is required."); hasError = true; }
                    if (message.length > 1000) { errorMessages.push("Message must not exceed 1000 characters."); hasError = true; }

                    if (hasError) {
                        displayErrors(errorMessages);
                    } else {
                        form.submit();
                    }
                });
            }

            function displayErrors(messages) {
                const errorMessagesDiv = document.getElementById("errorMessages");
                const errorList = document.getElementById("errorList");
                errorList.innerHTML = "";
                messages.forEach(message => {
                    const listItem = document.createElement("li");
                    listItem.textContent = message;
                    errorList.appendChild(listItem);
                });
                errorMessagesDiv.style.display = "block";
            }

            function clearErrors() {
                const errorMessagesDiv = document.getElementById("errorMessages");
                errorMessagesDiv.style.display = "none";
            }
        });
    </script>
    <?php endif; ?>
    
    <script src="scripts/hamburgermenu.js"></script>
    <script src="scripts/animationstyle.js"></script>
</body>
</html>