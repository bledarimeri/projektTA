<?php
include 'access.php';
checkAccess([1,2,3]); // Lejo qasje për desiminatorët dhe superadminët

include 'db.php';

// Merr desiminatorët për dropdown
$sql = "SELECT id, emri, mbiemri FROM desiminatoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$desiminatoret = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Merr raportet bazuar në desiminatorin e zgjedhur
$desiminator_id = isset($_GET['desiminator_id']) ? $_GET['desiminator_id'] : null;
if ($desiminator_id) {
    $sql = "SELECT r.id, r.titulli, r.data, r.pershkrimi, d.emri, d.mbiemri 
            FROM raportet r 
            JOIN desiminatoret d ON r.desiminator_id = d.id
            WHERE r.desiminator_id = :desiminator_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':desiminator_id', $desiminator_id);
} else {
    $sql = "SELECT r.id, r.titulli, r.data, r.pershkrimi, d.emri, d.mbiemri 
            FROM raportet r 
            JOIN desiminatoret d ON r.desiminator_id = d.id";
    $stmt = $conn->prepare($sql);
}
$stmt->execute();
$raportet = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Raportet e desiminatorëve</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .table th, .table td {
        font-size: 14px;
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1>Raportet e desiminatorëve</h1>
        <form method="get" action="raportet.php" class="mb-3">
            <label for="desiminator_id" class="form-label">Zgjidh Desiminatorin:</label>
            <select id="desiminator_id" name="desiminator_id" class="form-select">
                <option value="">Të gjithë</option>
                <?php foreach ($desiminatoret as $desiminator): ?>
                <option value="<?= htmlspecialchars($desiminator['id']) ?>"
                    <?= $desiminator_id == $desiminator['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($desiminator['emri'] . ' ' . $desiminator['mbiemri']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Filtro</button>
        </form>

        <table class="table table-striped table-bordered">
            <thead class="table-warning">
                <tr>
                    <th>Titulli</th>
                    <th>Data</th>
                    <th>Përshkrimi</th>
                    <th>Desiminatori</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($raportet as $raport): ?>
                <tr>
                    <td><?= htmlspecialchars($raport['titulli']) ?></td>
                    <td><?= htmlspecialchars($raport['data']) ?></td>
                    <td><?= htmlspecialchars($raport['pershkrimi']) ?></td>
                    <td><?= htmlspecialchars($raport['emri'] . ' ' . $raport['mbiemri']) ?></td>
                    <td>
                        <a href="./cikli_pvh.php" class="btn btn-success btn-sm">Shiko</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>