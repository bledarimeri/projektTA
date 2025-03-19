<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fshi mentorin nga baza e të dhënave
    $sql = "DELETE FROM mentoret WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Mentori u fshi me sukses!";
    } else {
        echo "Gabim gjatë fshirjes së mentorit.";
    }
} else {
    echo "ID e mentorit nuk është specifikuar.";
}
?>