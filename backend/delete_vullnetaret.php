<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fshi vullnetarin nga baza e të dhënave
    $sql = "DELETE FROM vullnetaret WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Vullnetari u fshi me sukses!";
    } else {
        echo "Gabim gjatë fshirjes së vullnetarit.";
    }
} else {
    echo "ID e vullnetarit nuk është specifikuar.";
}
?>