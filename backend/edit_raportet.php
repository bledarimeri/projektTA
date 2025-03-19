<?php
include 'db.php'; // Lidhja me databazën

// Marrja e ID-së nga URL
if (!isset($_GET['id'])) {
    die("Raporti nuk u gjet.");
}
$id = $_GET['id'];

// Marrja e të dhënave ekzistuese të raportit
$sql = "SELECT * FROM raportet WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$raporti = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$raporti) {
    die("Raporti nuk ekziston.");
}

// Përditësimi i të dhënave pas dërgimit të formës
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE raportet SET titulli = ?, data = ?, rajoni = ?, shkolla = ?, numri_pjesemarresve = ?, 
            drejtimet = ?, anet_pozitive = ?, raportin_pergatitur = ?, rekomandime = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['titulli'], $_POST['data'], $_POST['rajoni'], $_POST['shkolla'], $_POST['numri_pjesemarresve'],
        $_POST['drejtimet'], $_POST['anet_pozitive'], $_POST['raportin_pergatitur'], $_POST['rekomandime'], $id
    ]);
    
    echo "Raporti u përditësua me sukses!";
    header("Location: raportet.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifiko Raportin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Modifiko Raportin</h2>
        <form method="post">
            <label for="titulli">Titulli:</label>
            <input type="text" class="form-control" name="titulli" value="<?= htmlspecialchars($raporti['titulli']) ?>"
                required>

            <label for="data">Data:</label>
            <input type="date" class="form-control" name="data" value="<?= htmlspecialchars($raporti['data']) ?>"
                required>

            <label for="rajoni">Rajoni:</label>
            <input type="text" class="form-control" name="rajoni" value="<?= htmlspecialchars($raporti['rajoni']) ?>"
                required>

            <label for="shkolla">Shkolla:</label>
            <input type="text" class="form-control" name="shkolla" value="<?= htmlspecialchars($raporti['shkolla']) ?>"
                required>

            <label for="numri_pjesemarresve">Numri i pjesëmarrësve:</label>
            <input type="number" class="form-control" name="numri_pjesemarresve"
                value="<?= htmlspecialchars($raporti['numri_pjesemarresve']) ?>" required>

            <label for="drejtimet">Drejtimet:</label>
            <textarea class="form-control" name="drejtimet"
                required><?= htmlspecialchars($raporti['drejtimet']) ?></textarea>

            <label for="anet_pozitive">Anët pozitive/negative:</label>
            <textarea class="form-control" name="anet_pozitive"
                required><?= htmlspecialchars($raporti['anet_pozitive']) ?></textarea>

            <label for="raportin_pergatitur">Raportin e përgatitur:</label>
            <input type="text" class="form-control" name="raportin_pergatitur"
                value="<?= htmlspecialchars($raporti['raportin_pergatitur']) ?>" required>

            <label for="rekomandime">Rekomandime:</label>
            <textarea class="form-control" name="rekomandime"
                required><?= htmlspecialchars($raporti['rekomandime']) ?></textarea>

            <button type="submit" class="btn btn-success mt-3">Ruaj Ndryshimet</button>
            <a href="raportet.php" class="btn btn-secondary mt-3">Anulo</a>
        </form>
    </div>
</body>

</html>