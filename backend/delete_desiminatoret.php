<?php
include 'access.php';
checkAccess([1]); // Lejo qasje vetëm për adminët

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fshi desiminatoret
    $sql = "DELETE FROM desiminatoret WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: desiminatoret.php");
        exit;
    } else {
        echo "Gabim gjatë fshirjes.";
    }
}
?>