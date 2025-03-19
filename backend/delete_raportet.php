<?php
require 'db.php'; // Lidhja me databazën

if (!isset($_GET['id'])) {
    die("ID e raportit nuk u gjet.");
}

$id = $_GET['id'];

// Fshirja e raportit nga databaza
$sql = "DELETE FROM raportet WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$raporti = $stmt->fetch(PDO::FETCH_ASSOC);

// Kthehu te lista e raporteve
header("Location: raportet.php");
exit();
?>