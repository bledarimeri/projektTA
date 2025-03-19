<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Merr të dhënat e desiminatorit nga baza e të dhënave
    $sql = "SELECT * FROM desiminatoret WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $desiminatori = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$desiminatori) {
        echo "Desiminatori nuk u gjet.";
        exit;
    }
} else {
    echo "ID e desiminatorit nuk është specifikuar.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $email = $_POST['email'];
    $numri_telefonit = $_POST['numri_telefonit'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE desiminatoret SET emri = :emri, mbiemri = :mbiemri, email = :email, numri_telefonit = :numri_telefonit, password = :password WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $password);
    } else {
        $sql = "UPDATE desiminatoret SET emri = :emri, mbiemri = :mbiemri, email = :email, numri_telefonit = :numri_telefonit WHERE id = :id";
        $stmt = $conn->prepare($sql);
    }

    $stmt->bindParam(':emri', $emri);
    $stmt->bindParam(':mbiemri', $mbiemri);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':numri_telefonit', $numri_telefonit);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Të dhënat u rifreskuan me sukses!";
    } else {
        echo "Gabim gjatë rifreskimit të të dhënave.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Edito Desiminatorët</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 400px;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-container label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-container button {
        width: 100%;
        padding: 10px;
        background-color: #007b5e;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .form-container button:hover {
        background-color: #005a43;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Edito Desiminatorët</h2>
        <form method="post" action="">
            <label for="emri">Emri:</label>
            <input type="text" id="emri" name="emri" value="<?= htmlspecialchars($desiminatori['emri']) ?>" required>

            <label for="mbiemri">Mbiemri:</label>
            <input type="text" id="mbiemri" name="mbiemri" value="<?= htmlspecialchars($desiminatori['mbiemri']) ?>"
                required>

            <label for="email">Email-i:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($desiminatori['email']) ?>"
                required>

            <label for="numri_telefonit">Numri i telefonit:</label>
            <input type="text" id="numri_telefonit" name="numri_telefonit"
                value="<?= htmlspecialchars($desiminatori['numri_telefonit']) ?>" required>

            <label for="password">Password-i (Lëre të zbrazët për të mos ndryshuar):</label>
            <input type="password" id="password" name="password">

            <label for="confirm_password">Konfirmo Password-in:</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <button type="submit">Rifresko të dhënat</button>
        </form>
    </div>
</body>

</html>