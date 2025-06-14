<?php
$db_file = __DIR__ . '/../nfn_database.db';

try {
    $conn = new SQLite3($db_file);
    echo "Database connection successful!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
