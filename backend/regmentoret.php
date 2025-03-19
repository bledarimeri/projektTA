<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $email = $_POST['email'];
    $numri_telefonit = $_POST['numri_telefonit'];
    $qyteti_rajoni = $_POST['qyteti_rajoni'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO mentoret (emri, mbiemri, email, numri_telefonit, qyteti_rajoni, password) VALUES (:emri, :mbiemri, :email, :numri_telefonit, :qyteti_rajoni, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':emri', $emri);
    $stmt->bindParam(':mbiemri', $mbiemri);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':numri_telefonit', $numri_telefonit);
    $stmt->bindParam(':qyteti_rajoni', $qyteti_rajoni);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        echo "Mentori u regjistrua me sukses!";
    } else {
        echo "Gabim gjatë regjistrimit të mentorit.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Regjistro Mentor</title>
    <style>
    /* Shto stilet e duhura këtu */
    </style>
</head>

<body>
    <h1>Regjistro Mentor</h1>
    <form method="post" action="regmentoret.php">
        <label for="emri">Emri:</label>
        <input type="text" id="emri" name="emri" required><br><br>
        <label for="mbiemri">Mbiemri:</label>
        <input type="text" id="mbiemri" name="mbiemri" required><br><br>
        <label for="email">Email-i:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="numri_telefonit">Numri i telefonit:</label>
        <input type="text" id="numri_telefonit" name="numri_telefonit" required><br><br>
        <label for="qyteti_rajoni">Qyteti / Rajoni:</label>
        <input type="text" id="qyteti_rajoni" name="qyteti_rajoni"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="confirm_password">Konfirmo Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <button type="submit">Regjistro</button>
    </form>
</body>

</html>