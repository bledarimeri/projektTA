<?php
include 'db.php'; // Lidhja me bazën e të dhënave

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // ID e projektit
    $mentori = $_POST['mentori'];
    $vleresimi = $_POST['vleresimi'];

    // Përditëso të dhënat në tabelën projektet
    $sql = "UPDATE projektet SET mentori = :mentori, vleresimi = :vleresimi WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':mentori', $mentori);
    $stmt->bindParam(':vleresimi', $vleresimi);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Vlerësimi u ruajt me sukses!";
    } else {
        echo "Gabim gjatë ruajtjes së vlerësimit.";
    }
}
?>