<?php
try {
    $db = new SQLite3('test.db');
    echo "✅ SQLite is working and connected!";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
