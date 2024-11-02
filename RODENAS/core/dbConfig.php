<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "rodenas"; 
$dsn = "mysql:host={$host};dbname={$dbname}";

try {
    $pdo = new PDO($dsn, $user, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Optional confirmation message
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>