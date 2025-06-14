<?php
include('php/dp.php');  // Database connection
session_start();

$is_logged_in = false;

// Check login status using username (since it's the PK)
if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['user_id'];
    $sql = "SELECT status FROM user_info WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();

    $user = $result->fetchArray(SQLITE3_ASSOC);
    if ($user && $user['status'] == 1) {
        $is_logged_in = true;
        $_SESSION['username'] = $username;  // Make sure username session is set
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Natural Farming Network</title>
  <link rel="stylesheet" href="css/styles.css" />
   
</head>
<body>
  <!-- Navbar Section -->
  <nav id="navbar">
    <div id="logo">
      <img src="img/logo.jpg" alt="Natural Farming Logo" />
      <span>Natural Farming Network</span>
    </div>
    
  <div>
  <?php if ($is_logged_in): ?>
    <div id="nav-links">
      <a href="index.php">Home</a>
      <a href="html/farmmanagement.html" target="_blank">Farm Management</a>
      <a href="html/community&training.html" target="_blank">Community & Training</a>
      <a href="html/equipment&technology.html" target="_blank">Equipment & Technology</a>

      <?php
      // Input value for ML model
      $input = 5;

      // Prepare data in JSON format
      $data = json_encode(array("input" => $input));

      // Initialize CURL to Flask API URL (make sure /predict exists)
      $ch = curl_init('http://127.0.0.1:8000/predict');

      // Set CURL options
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($data)
      ));

      // Execute API request and get response
      $response = curl_exec($ch);
      curl_close($ch);

      // Decode the JSON response
      $result = json_decode($response, true);

      // Display prediction if available
      if ($result && isset($result['prediction'])) {
          echo "<p><strong>Prediction from ML model:</strong> " . htmlspecialchars($result['prediction']) . "</p>";
      } else {
          echo "<p><strong>Error:</strong> Unable to get prediction. Please check the API response.</p>";
      }
      ?>

      <a href="html/ai_features.html" target="_blank">AI Features</a>
      <a href="php/logout.php" class="btn-logout">Logout</a>
    </div>
  <?php else: ?>
    <span>Please login to access more features and explore more.</span>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="php/login.php" class="btn-login">Login</a>
  <?php endif; ?>
</div>

  </nav>

  <!-- Hero Section -->
  <section id="hero">
    <div class="hero-content">
       <?php if ($is_logged_in): ?>
       <span>👋 Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      <?php else: ?>
      <?php endif; ?>
      <h1>Welcome to Natural Farming Network</h1>
      <p>Empowering farmers with sustainable and eco-friendly farming practices.</p>
      <a href="html/applications.html" class="btn-primary">Explore Applications</a>
    </div>
  </section>

  <!-- Highlight Section -->
  <section id="highlight">
    <div class="highlight-card">
      <h2>Why Choose Natural Farming?</h2>
      <p>Natural farming is a sustainable approach that reduces costs, improves soil health, and increases crop yield.</p>
    </div>
    <div class="highlight-card">
      <h2>Join Our Community</h2>
      <p>Connect with farmers worldwide and share your experiences.</p>
    </div>
    <div class="highlight-card">
      <h2>Learn New Techniques</h2>
      <p>Discover innovative farming methods and technologies.</p>
    </div>
  </section>

  <!-- Main Content Section -->
  <section class="content">
    <div class="card">
      <h2>Natural Farming: A Sustainable Way of Farming!</h2>
      <p>Agriculture is at epicentre of the country’s journey towards Atma Nirbharta (Self reliance) with farmers at its core. The efforts of our government have consistently focused upon upliftment, empowerment and stability of farmers in the technical, economic and social realm. It is in this endeavour that we continuously explore various methods to achieve ecologically sustainable and economically viable methods. Natural farming is one such method that holds potential to realise all these goals. It is backed by our rich traditional knowledge, and is a practice of agriculture based on locally available resources, which makes it a sustainable and viable practice.</p>
    </div>
    <div class="card">
      <h2>State Practicing Natural Farming:</h2>
      <p>There are several states practicing Natural Farming. Prominent among them are Andhra Pradesh, Himachal Pradesh, Gujarat, Kerala, Jharkhand, Odisha, Madhya Pradesh, Rajasthan, Uttar Pradesh and Tamil Nadu.</p>
    </div>
  </section>

  <!-- Related Links Section -->
  <section id="related-links">
    <h2>Related Links</h2>
    <div class="links-grid">
      <a href="https://en.wikipedia.org/wiki/Natural_farming" target="_blank" class="link-card">
        <h3>Wikipedia: Natural Farming</h3>
        <p>Learn more about natural farming on Wikipedia.</p>
      </a>
      <a href="https://naturalfarming.dac.gov.in/" target="_blank" class="link-card">
        <h3>National Mission on Natural Farming Management and Knowledge Portal</h3>
        <p>Learn more about natural farming on National Mission on Natural Farming Management and Knowledge Portal</p>
      </a>
      <a href="https://www.sare.org" target="_blank" class="link-card">
        <h3>Sustainable Agriculture Research</h3>
        <p>Discover sustainable farming practices with SARE.</p>
      </a>
    </div>
  </section>

  <!-- Farmer Story Section -->
  <section id="farmer-story">
    <div class="story-content">
      <h2>Story of Dr. Manickaraj and Mrs. Nagarathinam</h2>
      <p>Dr. Manickaraj and Mrs. Nagarathinam started their journey in farming around 25 years ago. In the last 17 years, they have stuck to only natural farming methods. Despite lots of challenges and losses, they persevered. Today, they are happy with the output from their farm. In this video, the couple take us around to show us the different trees, crops, and other livestock components in their farm.</p>
    </div>
    <div class="story-video">
      <iframe width="500" height="295" src="https://www.youtube.com/embed/R_wkI_AsdNk?si=1G8MZp1V-ysLCMZa" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
  </section>

  <!-- Footer Section -->
  <footer id="footer">
    <div class="footer-content">
      <div class="urrent-year"> <p>&copy; <span id="current-year">2024</span> Natural Farming Network. All Rights Reserved.</p></div>
       <div>
       <a href="/privacy-policy">Privacy Policy</a>
      <a href="/terms-of-service">Terms of Service</a>
      <a href="/contact">Contact Us</a>
    </div>
      <!-- <div class="footer-links">
          <a href="/privacy-policy">Privacy Policy</a>
      <a href="/terms-of-service">Terms of Service</a>
      <a href="/contact">Contact Us</a><br>
        <a href="https://www.youtube.com" target="_blank"><img src="img/youtube-icon.png" alt="YouTube" /></a>
        <a href="https://www.instagram.com" target="_blank"><img src="img/Instagram-Icon.png" alt="Instagram" /></a>
        <a href="https://www.facebook.com" target="_blank"><img src="img/facebook-icon.png" alt="Facebook" /></a>
        <a href="https://telegram.org" target="_blank"><img src="img/telegram-icon.png" alt="Telegram" /></a>
      </div>
      <p>Website Content Managed by internship group of Mishta Kishan, Rahul, Gautam & Prince</p>
      <p>Designed and Developed by PK Prince Raj</p>
    </div>
      -->
  </footer>
</body>
</html>
