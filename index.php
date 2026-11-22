<?php
session_start();

$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? (string) $_SESSION['user_id'] : '';

if ($is_logged_in) {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Natural Farming Network — sustainable farming resources, community support, and practical guidance for farmers.">
  <title>Natural Farming Network</title>
  <link rel="icon" href="img/logo.jpg" type="image/jpeg">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<nav id="navbar" aria-label="Primary navigation">
  <div id="logo">
    <img src="img/logo.jpg" alt="" width="50" height="50">
    <span>Natural Farming Network</span>
  </div>

  <div id="nav-links">
    <a href="index.php" class="active" aria-current="page">Home</a>
    <a href="html/farmmanagement.html" target="_blank" rel="noopener noreferrer">Farm Management</a>
    <a href="html/community&amp;training.html" target="_blank" rel="noopener noreferrer">Community &amp; Training</a>
    <a href="html/equipment&amp;technology.html" target="_blank" rel="noopener noreferrer">Equipment &amp; Technology</a>
    <a href="php/ml.php" target="_blank" rel="noopener noreferrer">AI Features</a>
    <?php if ($is_logged_in): ?>
      <a href="php/logout.php">Logout</a>
    <?php else: ?>
      <a href="html/login.html">Login</a>
    <?php endif; ?>
  </div>
</nav>

<main>
  <section id="hero">
    <div class="hero-content">
      <?php if ($is_logged_in): ?>
        <span>👋 Hello, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
      <?php endif; ?>
      <h1>Welcome to Natural Farming Network</h1>
      <p>Empowering farmers with sustainable and eco-friendly farming practices.</p>
      <a href="html/applications.html" class="btn-primary">Explore Applications</a>
    </div>
  </section>

  <section id="highlight" aria-label="Benefits">
    <article class="highlight-card">
      <h2>Why Choose Natural Farming?</h2>
      <p>Natural farming is a sustainable approach that reduces costs, improves soil health, and increases crop yield.</p>
    </article>
    <article class="highlight-card">
      <h2>Join Our Community</h2>
      <p>Connect with farmers worldwide and share your experiences.</p>
    </article>
    <article class="highlight-card">
      <h2>Learn New Techniques</h2>
      <p>Discover innovative farming methods and technologies.</p>
    </article>
  </section>

  <section class="content" aria-label="About natural farming">
    <article class="card">
      <h2>Natural Farming: A Sustainable Way of Farming!</h2>
      <p>Agriculture is at the epicentre of the country’s journey towards Atma Nirbharta (Self Reliance).</p>
    </article>
    <article class="card">
      <h2>States Practicing Natural Farming</h2>
      <p>Andhra Pradesh, Himachal Pradesh, Gujarat, Kerala, Jharkhand, Odisha, Madhya Pradesh and more.</p>
    </article>
  </section>

  <section id="related-links">
    <h2>Related Links</h2>
    <div class="links-grid">
      <a href="https://en.wikipedia.org/wiki/Natural_farming" target="_blank" rel="noopener noreferrer" class="link-card">
        <h3>Wikipedia: Natural Farming</h3>
        <p>Learn more about natural farming on Wikipedia.</p>
      </a>
      <a href="https://naturalfarming.dac.gov.in/" target="_blank" rel="noopener noreferrer" class="link-card">
        <h3>National Mission on Natural Farming</h3>
        <p>Learn more on the official portal.</p>
      </a>
      <a href="https://www.sare.org" target="_blank" rel="noopener noreferrer" class="link-card">
        <h3>Sustainable Agriculture Research</h3>
        <p>Discover sustainable farming practices with SARE.</p>
      </a>
    </div>
  </section>

  <section id="farmer-story">
    <div class="story-content">
      <h2>Story of Dr. Manickaraj and Mrs. Nagarathinam</h2>
      <p>They started farming 25 years ago and have followed natural farming methods exclusively for the last 17 years.</p>
    </div>
  </section>
</main>

<footer id="footer">
  <div class="footer-content">
    <p>&copy; <?php echo date('Y'); ?> Natural Farming Network. All Rights Reserved.</p>
    <div>
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Contact Us</a>
    </div>
  </div>
</footer>
</body>
</html>
