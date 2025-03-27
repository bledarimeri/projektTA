<?php
include 'db.php';



if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Merr të dhënat e projektit nga baza e të dhënave
    $sql = "SELECT * FROM projektet WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $projekti = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$projekti) {
        echo "Projekti nuk u gjet.";
        exit;
    }
} else {
    echo "ID e projektit nuk është specifikuar.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulli = $_POST['titulli'];
    $mentori_id = $_POST['mentori_id'];
    $desiminatori_id = $_POST['desiminatori_id'];
    $vleresimi = $_POST['vleresimi'];

    $sql = "UPDATE projektet SET titulli = :titulli, mentori_id = :mentori_id, desiminatori_id = :desiminatori_id, vleresimi = :vleresimi WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titulli', $titulli);
    $stmt->bindParam(':mentori_id', $mentori_id);
    $stmt->bindParam(':desiminatori_id', $desiminatori_id);
    $stmt->bindParam(':vleresimi', $vleresimi);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Të dhënat u rifreskuan me sukses!";
    } else {
        echo "Gabim gjatë rifreskimit të të dhënave.";
    }
}

// Merr mentorët dhe desiminatorët për dropdown
$sql = "SELECT id, emri, mbiemri FROM mentoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$mentorët = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT id, emri, mbiemri FROM desiminatoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$desiminatorët = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Edito Projektin</title>
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
        <h2>Edito Projektin</h2>
        <form method="post" action="">
            <label for="titulli">Titulli:</label>
            <input type="text" id="titulli" name="titulli" value="<?= htmlspecialchars($projekti['titulli']) ?>"
                required>

            <label for="mentori_id">Mentori:</label>
            <select id="mentori_id" name="mentori_id" required>
                <?php foreach ($mentorët as $mentori): ?>
                <option value="<?= htmlspecialchars($mentori['id']) ?>"
                    <?= $projekti['mentori_id'] == $mentori['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($mentori['emri'] . ' ' . $mentori['mbiemri']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="desiminatori_id">Desiminatori:</label>
            <select id="desiminatori_id" name="desiminatori_id" required>
                <?php foreach ($desiminatorët as $desiminator): ?>
                <option value="<?= htmlspecialchars($desiminator['id']) ?>"
                    <?= $projekti['desiminatori_id'] == $desiminator['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($desiminator['emri'] . ' ' . $desiminator['mbiemri']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="vleresimi">Vlerësimi:</label>
            <input type="number" id="vleresimi" name="vleresimi" value="<?= htmlspecialchars($projekti['vleresimi']) ?>"
                step="0.01" required>

            <button type="submit">Rifresko të dhënat</button>
        </form>
    </div>
</body>

</html>