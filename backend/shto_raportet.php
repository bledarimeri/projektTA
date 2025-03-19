<?php
include 'db.php';

// Merr desiminatorët për dropdown
$sql = "SELECT id, emri, mbiemri FROM desiminatoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$desiminatoret = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $desiminator_id = $_POST['desiminator_id'];
    $titulli = $_POST['titulli'];
    $data = $_POST['data'];
    $rajoni = $_POST['rajoni'];
    $shkolla = $_POST['shkolla'];
    $numri_pjesemarresve = $_POST['numri_pjesemarresve'];
    $drejtimet = $_POST['drejtimet'];
    $anet_pozitive = $_POST['anet_pozitive'];
    $raportin_pergatitur = $_POST['raportin_pergatitur'];
    $rekomandime = $_POST['rekomandime'];

    $sql = "INSERT INTO raportet (desiminator_id, titulli, data, rajoni, shkolla, numri_pjesemarresve, drejtimet, anet_pozitive, raportin_pergatitur, rekomandime) VALUES (:desiminator_id, :titulli, :data, :rajoni, :shkolla, :numri_pjesemarresve, :drejtimet, :anet_pozitive, :raportin_pergatitur, :rekomandime)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':desiminator_id', $desiminator_id);
    $stmt->bindParam(':titulli', $titulli);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':rajoni', $rajoni);
    $stmt->bindParam(':shkolla', $shkolla);
    $stmt->bindParam(':numri_pjesemarresve', $numri_pjesemarresve);
    $stmt->bindParam(':drejtimet', $drejtimet);
    $stmt->bindParam(':anet_pozitive', $anet_pozitive);
    $stmt->bindParam(':raportin_pergatitur', $raportin_pergatitur);
    $stmt->bindParam(':rekomandime', $rekomandime);

    if ($stmt->execute()) {
        echo "Raporti u shtua me sukses!";
    } else {
        echo "Gabim gjatë shtimit të raportit.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Shto Raport</title>
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
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 600px;
        height: 100%;
        overflow: auto;
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
    .form-container input[type="date"],
    .form-container textarea,
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
        <h2>Shto Raport</h2>
        <form method="post" action="">
            <label for="desiminator_id">Desiminatori:</label>
            <select id="desiminator_id" name="desiminator_id" required>
                <option value="">Zgjidh Desiminatorin</option>
                <?php foreach ($desiminatoret as $desiminator): ?>
                <option value="<?= htmlspecialchars($desiminator['id']) ?>">
                    <?= htmlspecialchars($desiminator['emri'] . ' ' . $desiminator['mbiemri']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="titulli">Titulli:</label>
            <input type="text" id="titulli" name="titulli" required>

            <label for="data">Data e raportit:</label>
            <input type="date" id="data" name="data" required>

            <label for="rajoni">Rajoni:</label>
            <input type="text" id="rajoni" name="rajoni" required>

            <label for="shkolla">Shkolla:</label>
            <input type="text" id="shkolla" name="shkolla" required>

            <label for="numri_pjesemarresve">Numri i pjesëmarrësve:</label>
            <input type="text" id="numri_pjesemarresve" name="numri_pjesemarresve" required>

            <label for="drejtimet">A janë përcjellur drejtimet për PVH desiminimin apo keni shtuar elemente
                shtesë?</label>
            <textarea id="drejtimet" name="drejtimet" required></textarea>

            <label for="anet_pozitive">Anët pozitive/negative të orëve (hapësira, pasija, interesi):</label>
            <textarea id="anet_pozitive" name="anet_pozitive" required></textarea>

            <label for="raportin_pergatitur">Raportin e përgatitur/ten:</label>
            <input type="text" id="raportin_pergatitur" name="raportin_pergatitur" required>

            <label for="rekomandime">Rekomandime për postime:</label>
            <textarea id="rekomandime" name="rekomandime" required></textarea>

            <button type="submit">Dërgo</button>
            <button type="button" onclick="window.print()">Shkarko PDF</button>
        </form>
    </div>
</body>

</html>