<?php
include 'db.php';

// Merr mentorët dhe desiminatorët për dropdown
$sql = "SELECT id, emri, mbiemri FROM mentoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$mentorët = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT id, emri, mbiemri FROM desiminatoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$desiminatorët = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulli = $_POST['titulli'];
    $mentori_id = $_POST['mentori_id'];
    $desiminatori_id = $_POST['desiminatori_id'];
    $vleresimi = $_POST['vleresimi'];

    $sql = "INSERT INTO projektet (titulli, mentori_id, desiminatori_id, vleresimi) VALUES (:titulli, :mentori_id, :desiminatori_id, :vleresimi)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titulli', $titulli);
    $stmt->bindParam(':mentori_id', $mentori_id);
    $stmt->bindParam(':desiminatori_id', $desiminatori_id);
    $stmt->bindParam(':vleresimi', $vleresimi);

    if ($stmt->execute()) {
        echo "Projekti u shtua me sukses!";
    } else {
        echo "Gabim gjatë shtimit të projektit.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Shto Projekt</title>
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
    .form-container input[type="number"],
    .form-container select {
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
        <h2>Shto Projekt</h2>
        <form method="post" action="">
            <label for="titulli">Titulli:</label>
            <input type="text" id="titulli" name="titulli" required>

            <label for="mentori_id">Mentori:</label>
            <select id="mentori_id" name="mentori_id" required>
                <option value="">Zgjidh Mentor</option>
                <?php foreach ($mentorët as $mentori): ?>
                <option value="<?= htmlspecialchars($mentori['id']) ?>">
                    <?= htmlspecialchars($mentori['emri'] . ' ' . $mentori['mbiemri']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="desiminatori_id">Desiminatori:</label>
            <select id="desiminatori_id" name="desiminatori_id" required>
                <option value="">Zgjidh Desiminator</option>
                <?php foreach ($desiminatorët as $desiminator): ?>
                <option value="<?= htmlspecialchars($desiminator['id']) ?>">
                    <?= htmlspecialchars($desiminator['emri'] . ' ' . $desiminator['mbiemri']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="vleresimi">Vlerësimi:</label>
            <input type="number" id="vleresimi" name="vleresimi" step="0.1" max="10" required>

            <button type="submit">Shto Projekt</button>
        </form>
    </div>
</body>

</html>