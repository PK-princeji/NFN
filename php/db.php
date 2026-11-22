<?php

/**
 * Shared SQLite database connection.
 */

$dbPath = dirname(__DIR__) . '/db/farming.db';

try {
    $db = new SQLite3($dbPath);
    $db->enableExceptions(true);
} catch (Throwable $e) {
    http_response_code(500);
    exit('Database unavailable.');
}
