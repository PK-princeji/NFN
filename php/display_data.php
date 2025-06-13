<?php
// Include the database connection file
include('db.php');

// Initialize variables
$data = []; // Array to store fetched data
$error_message = ""; // Variable to store error messages

// Fetch data from the 'users' table using prepared statements
$sql = "SELECT * FROM users"; // SQL query to select all rows from the 'users' table
$stmt = $conn->prepare($sql); // Prepare the SQL statement

if ($stmt) {
    $stmt->execute(); // Execute the prepared statement
    $result = $stmt->get_result(); // Get the result set

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Fetch all rows as associative arrays and store them in the $data array
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $error_message = "No records found."; // No data found in the table
    }
    $stmt->close(); // Close the prepared statement
} else {
    $error_message = "Error preparing SQL statement: " . $conn->error; // Error in SQL preparation
}
$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Agriculture Data</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
    <script src="script.js" defer></script> <!-- Link to external JavaScript -->
</head>
<body>
    <!-- Navigation Bar -->
    <div id="navid1">
        <div id="logoid">
            <img id="mylogo" class="zoomInLeft" src="logo.jpg" alt="Logo">
            <h1 style="color: rgb(134, 24, 43); margin-left:30px; text-align: center; margin-top: 20px;">
                NATURAL FARMING <br> NETWORK
            </h1>
        </div>
        <div id="adl">
            <a href="userinput.php">Share farming experience</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="display_data.php">View farmer experience</a>
        </div>
        <div id="linking">
            <a href="logout.php">
                <img src="logout_icon.jpg" alt="Logout" style="height: 50px; width: 60px; border-radius: 250px; border: 1px solid black;">
            </a>
            <a href="https://www.youtube.com/@PrinceKumar-ed9ok/shorts">
                <img src="youtube_icon.jpg" alt="YouTube" style="border-radius: 35px; width: 60px; height: 60px; border: 3px solid green;">
            </a>
            <a href="https://www.instagram.com/princeji3242/">
                <img src="instagram_icon.jpg" alt="Instagram" width="60px" height="60px" style="border-radius: 35px; border: 3px solid green;">
            </a>
            <a href="https://m.facebook.com/profile.php?id=100094146573978">
                <img src="facebook_icon.jpg" alt="Facebook" width="60px" height="60px" style="border-radius: 35px; border: 3px solid green;">
            </a>
            <a href="https://t.me/+VSU5uUScVkEyN2Jl">
                <img src="telegram_icon.jpg" alt="Telegram" width="60px" height="60px" style="border-radius: 35px; border: 3px solid green;">
            </a>
        </div>
    </div>

    <!-- Slideshow -->
    <div class="slideshow-container">
        <img id="slideshow" src="combined (1).jpg" alt="Slideshow Image">
    </div>

    <!-- Data Display Section -->
    <h2>Submitted Agriculture Data</h2>
    <div class="data-container">
        <?php if (!empty($data)): ?>
            <?php foreach ($data as $entry): ?>
                <div class="data-div">
                    <h3>Crop Information</h3>
                    <p><label>Name:</label> <?php echo htmlspecialchars($entry['name']); ?></p>
                    <p><label>Email:</label> <?php echo htmlspecialchars($entry['email']); ?></p>
                    <p><label>Mobile No:</label> <?php echo htmlspecialchars($entry['mobile_no']); ?></p>
                    <p><label>Address:</label> <?php echo nl2br(htmlspecialchars($entry['address'])); ?></p>
                    <p><label>Crop Type:</label> <?php echo htmlspecialchars($entry['crop_type']); ?></p>
                    <p><label>Season:</label> <?php echo htmlspecialchars($entry['season']); ?></p>
                    <p><label>Location:</label> <?php echo htmlspecialchars($entry['location']); ?></p>
                    <p><label>Market Price:</label> <?php echo htmlspecialchars($entry['market_price']); ?></p>
                    <p><label>Water Availability:</label> <?php echo htmlspecialchars($entry['water_availability']); ?></p>
                    <p><label>Soil Type:</label> <?php echo htmlspecialchars($entry['soil_type']); ?></p>
                    <p><label>Irrigation Requirement:</label> <?php echo htmlspecialchars($entry['irrigation_requirement']); ?></p>
                    <p><label>Expected Yield:</label> <?php echo htmlspecialchars($entry['expected_yield']); ?></p>
                    <p><label>Pest/Disease Info:</label> <?php echo nl2br(htmlspecialchars($entry['pest_disease_info'])); ?></p>
                    <p><label>Fertilizer Requirements:</label> <?php echo nl2br(htmlspecialchars($entry['fertilizer_requirements'])); ?></p>
                    <p><label>Time to Harvest (in days):</label> <?php echo htmlspecialchars($entry['time_to_harvest']); ?></p>
                    <p><label>Additional Problems:</label> <?php echo nl2br(htmlspecialchars($entry['additional_problems'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?php echo isset($error_message) ? $error_message : "No data available"; ?></p>
        <?php endif; ?>
    </div>

    <!-- Back Link -->
    <div class="back-link">
        <a href="userinput.php">Back to Form</a>
    </div>

    <!-- Footer -->
    <footer id="footer">
        <p style="text-align:center; color: rgb(169, 122, 157); padding-top: 30px;" class="font-14 mb-12">
            Website Content Managed by internship group of Mishta Kishan, Rahul, Gautam &amp; Prince
            <br>
            Designed and Developed by PK Prince Raj
        </p>
    </footer>
</body>
</html>