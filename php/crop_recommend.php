<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $args = implode(" ", [
        escapeshellarg($_POST['nitrogen']),
        escapeshellarg($_POST['phosphorus']),
        escapeshellarg($_POST['potassium']),
        escapeshellarg($_POST['ph']),
        escapeshellarg($_POST['rainfall']),
        escapeshellarg($_POST['temperature']),
        escapeshellarg($_POST['humidity']),
    ]);

    $command = "python ../ai/crop_model.py $args";
    $output = shell_exec($command);
    echo "<h2>Recommended Crop:</h2><p>" . htmlspecialchars($output) . "</p>";
}
?>
