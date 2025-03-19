<?php
$host = 'localhost';
$db_name = 'projektTA';
$username = 'root';
$password = '';

// Krijo lidhjen
try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Vendos PDO në modën e gabimeve për të hedhur përjashtime
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Lidhja dështoi: " . $e->getMessage());
}
?>