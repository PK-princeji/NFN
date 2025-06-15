<?php
$db = new SQLite3('../db/farming.db');

// Create user table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY,
    username TEXT UNIQUE,
    password TEXT
)");

// Create crop history
$db->exec("CREATE TABLE IF NOT EXISTS crop_history (
    id INTEGER PRIMARY KEY,
    user TEXT,
    soil TEXT,
    temperature REAL,
    humidity REAL,
    crop TEXT,
    date TEXT
)");

// Create fertilizer history
$db->exec("CREATE TABLE IF NOT EXISTS fertilizer_history (
    id INTEGER PRIMARY KEY,
    user TEXT,
    n INTEGER,
    p INTEGER,
    k INTEGER,
    suggestion TEXT,
    date TEXT
)");

// Create disease logs
$db->exec("CREATE TABLE IF NOT EXISTS disease_logs (
    id INTEGER PRIMARY KEY,
    user TEXT,
    filename TEXT,
    disease TEXT,
    date TEXT
)");
?>
