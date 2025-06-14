<?php
$db_file = __DIR__ . '/../nfn_database.db';  // ये ROOT folder से DB को access करेगा
$conn = new SQLite3($db_file);

if (!$conn) {
    die("Connection failed.");
}
?>
