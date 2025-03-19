<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Merr të dhënat e raportit nga baza e të dhënave
    $sql = "SELECT * FROM raportet WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $raporti = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$raporti) {
        echo "Raporti nuk u gjet.";
        exit;
    }
} else {
    echo "ID e raportit nuk është specifikuar.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST['data'];
    $rajoni = $_POST['rajoni'];
    $shkolla = $_POST['shkolla'];
    $numri_pjesemarresve = $_POST['numri_pjesemarresve'];
    $drejtimet = $_POST['drejtimet'];
    $anet_pozitive = $_POST['anet_pozitive'];
    $raportin_pergatitur = $_POST['raportin_pergatitur'];
    $rekomandime = $_POST['rekomandime'];

    $sql = "UPDATE raportet SET data = :data, rajoni = :rajoni, shkolla = :shkolla, numri_pjesemarresve = :numri_pjesemarresve, drejtimet = :drejtimet, anet_pozitive = :anet_pozitive, raportin_pergatitur = :raportin_pergatitur, rekomandime = :rekomandime WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':rajoni', $rajoni);
    $stmt->bindParam(':shkolla', $shkolla);
    $stmt->bindParam(':numri_pjesemarresve', $numri_pjesemarresve);
    $stmt->bindParam(':drejtimet', $drejtimet);
    $stmt->bindParam(':anet_pozitive', $anet_pozitive);
    $stmt->bindParam(':raportin_pergatitur', $raportin_pergatitur);
    $stmt->bindParam(':rekomandime', $rekomandime);
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
    <title>Raporti <?= htmlspecialchars($raporti['titulli']) ?></title>
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
    .form-container textarea {
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
        margin-bottom: 5px;
    }

    .form-container button:hover {
        background-color: #005a43;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Raporti <?= htmlspecialchars($raporti['titulli']) ?></h2>
        <form method="post" action="">
            <label for="data">Data e raportit:</label>
            <input type="date" id="data" name="data" value="<?= htmlspecialchars($raporti['data']) ?>" required>

            <label for="rajoni">Rajoni:</label>
            <input type="text" id="rajoni" name="rajoni" value="<?= htmlspecialchars($raporti['rajoni']) ?>" required>

            <label for="shkolla">Shkolla:</label>
            <input type="text" id="shkolla" name="shkolla" value="<?= htmlspecialchars($raporti['shkolla']) ?>"
                required>

            <label for="numri_pjesemarresve">Numri i pjesëmarrësve:</label>
            <input type="text" id="numri_pjesemarresve" name="numri_pjesemarresve"
                value="<?= htmlspecialchars($raporti['numri_pjesemarresve']) ?>" required>

            <label for="drejtimet">A janë përcjellur drejtimet për PVH desiminimin apo keni shtuar elemente
                shtesë?</label>
            <textarea id="drejtimet" name="drejtimet" required><?= htmlspecialchars($raporti['drejtimet']) ?></textarea>

            <label for="anet_pozitive">Anët pozitive/negative të orëve (hapësira, pasija, interesi):</label>
            <textarea id="anet_pozitive" name="anet_pozitive"
                required><?= htmlspecialchars($raporti['anet_pozitive']) ?></textarea>

            <label for="raportin_pergatitur">Raportin e përgatitur/ten:</label>
            <input type="text" id="raportin_pergatitur" name="raportin_pergatitur"
                value="<?= htmlspecialchars($raporti['raportin_pergatitur']) ?>" required>

            <label for="rekomandime">Rekomandime për postime:</label>
            <textarea id="rekomandime" name="rekomandime"
                required><?= htmlspecialchars($raporti['rekomandime']) ?></textarea>

            <button type="submit">Dërgo</button>
            <button type="button" onclick="window.print()">Shkarko PDF</button>
        </form>
    </div>
</body>

</html>