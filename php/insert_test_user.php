<?php
try {
    $db = new SQLite3('test.db');
    echo "SQLite3 connection successful!";
} catch (Exception $e) {
    echo "SQLite3 connection failed: " . $e->getMessage();
}
?>
