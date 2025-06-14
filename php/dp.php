<?php
// SQLite connection
$db_file = __DIR__ . '/nfn_database.db'; // DB file path
$conn = new SQLite3($db_file);

// Check connection
if (!$conn) {
    die("Connection failed.");
}
?>
