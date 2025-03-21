<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    die("Nuk keni qasje!");
}


// Këtu vjen logjika për menaxhimin e përdoruesve...
echo "<h2>Paneli i Super Adminit - Menaxhimi i Përdoruesve</h2>";
?>