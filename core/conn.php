<?php

$conn = new mysqli($db["host"], $db["user"], $db["pass"], $db["table"]);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    // Something went wrong?
    die("Couldn't connect to Database: " . $conn->connect_error);
}

// If not, we can get our config :D
$config = $conn->query("SELECT * FROM  `config` ORDER BY `id` ASC");

