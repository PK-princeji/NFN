<!DOCTYPE html>
<html>
<head>
  <title>AI Farming Tools</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <h1>🌾 AI-Powered Farming Features</h1>

  <h2>🌱 Crop Recommendation</h2>
  <form action="crop_recommend.php" method="post">
    <input type="text" name="nitrogen" placeholder="Nitrogen">
    <input type="text" name="phosphorus" placeholder="Phosphorus">
    <input type="text" name="potassium" placeholder="Potassium">
    <input type="text" name="ph" placeholder="pH">
    <input type="text" name="rainfall" placeholder="Rainfall">
    <input type="text" name="temperature" placeholder="Temperature">
    <input type="text" name="humidity" placeholder="Humidity">
    <button type="submit">Recommend Crop</button>
  </form>

  <h2>💧 Fertilizer Suggestion</h2>
  <form action="fertilizer_suggest.php" method="post">
    <input type="text" name="crop_name" placeholder="Crop Name">
    <input type="text" name="soil_type" placeholder="Soil Type">
    <input type="text" name="moisture" placeholder="Moisture">
    <button type="submit">Suggest Fertilizer</button>
  </form>

  <h2>🦠 Disease Detection</h2>
  <form action="disease_detect.php" method="post" enctype="multipart/form-data">
    <input type="file" name="image">
    <button type="submit">Detect Disease</button>
  </form>
</body>
</html>
