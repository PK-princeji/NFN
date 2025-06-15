<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $command = "python ../ai/disease_model.py " . escapeshellarg($target_file);
        $output = shell_exec($command);
        echo "<h2>Disease Detection Result:</h2><p>" . htmlspecialchars($output) . "</p>";
    } else {
        echo "Error uploading file.";
    }
}
?>
