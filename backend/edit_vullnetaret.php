<?php
include 'access.php';
checkAccess([1]); // Lejo qasje vetëm për adminët

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Merr të dhënat e vullnetarit
    $sql = "SELECT * FROM vullnetaret WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $mentori = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$mentori) {
        echo "Mentori nuk u gjet.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $email = $_POST['email'];
    $numri_telefonit = $_POST['numri_telefonit'];

    // Përditëso të dhënat e vullnetarit
    $sql = "UPDATE vullnetaret SET emri = :emri, mbiemri = :mbiemri, email = :email, numri_telefonit = :numri_telefonit WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':emri', $emri);
    $stmt->bindParam(':mbiemri', $mbiemri);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':numri_telefonit', $numri_telefonit);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: vullnetaret.php");
        exit;
    } else {
        echo "Gabim gjatë përditësimit.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Edito Vullnetaret</title>
</head>

<body>
    <h1>Edito Vullnetaret</h1>
    <form method="post" action="edit_vullnetaret.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($mentori['id']) ?>">
        <label for="emri">Emri:</label>
        <input type="text" id="emri" name="emri" value="<?= htmlspecialchars($mentori['emri']) ?>" required><br>
        <label for="mbiemri">Mbiemri:</label>
        <input type="text" id="mbiemri" name="mbiemri" value="<?= htmlspecialchars($mentori['mbiemri']) ?>"
            required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($mentori['email']) ?>" required><br>
        <label for="numri_telefonit">Numri i Telefonit:</label>
        <input type="text" id="numri_telefonit" name="numri_telefonit"
            value="<?= htmlspecialchars($mentori['numri_telefonit']) ?>" required><br>
        <button type="submit">Përditëso</button>
    </form>
</body>

</html>