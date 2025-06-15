<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $args = implode(" ", [
        escapeshellarg($_POST['crop_name']),
        escapeshellarg($_POST['soil_type']),
        escapeshellarg($_POST['moisture']),
    ]);

    $command = "python ../ai/fertilizer_model.py $args";
    $output = shell_exec($command);
    echo "<h2>Fertilizer Suggestion:</h2><p>" . htmlspecialchars($output) . "</p>";
}
?>
