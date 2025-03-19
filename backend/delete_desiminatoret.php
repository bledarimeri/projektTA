<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fshi desiminatorin nga baza e të dhënave
    $sql = "DELETE FROM desiminatoret WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Desiminatori u fshi me sukses!";
    } else {
        echo "Gabim gjatë fshirjes së desiminatorit.";
    }
} else {
    echo "ID e desiminatorit nuk është specifikuar.";
}
?>