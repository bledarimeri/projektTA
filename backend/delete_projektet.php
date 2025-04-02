<!-- <?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fshi projektin nga baza e të dhënave
    $sql = "DELETE FROM projektet WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Projekti u fshi me sukses!";
    } else {
        echo "Gabim gjatë fshirjes së projektit.";
    }
} else {
    echo "ID e projektit nuk është specifikuar.";
}
?> -->