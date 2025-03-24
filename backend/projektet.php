<?php

include 'access.php';
checkAccess([1,2,3]); // Lejo qasje për mentorët, desiminatorët dhe superadminët

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

// Merr projektet bazuar në filtrat e zgjedhur
$mentori_id = isset($_GET['mentori_id']) ? $_GET['mentori_id'] : null;
$desiminatori_id = isset($_GET['desiminatori_id']) ? $_GET['desiminatori_id'] : null;

$sql = "SELECT p.id, p.titulli, p.vleresimi, m.emri AS mentori_emri, m.mbiemri AS mentori_mbiemri, d.emri AS desiminatori_emri, d.mbiemri AS desiminatori_mbiemri 
        FROM projektet p 
        JOIN mentoret m ON p.mentori_id = m.id 
        JOIN desiminatoret d ON p.desiminatori_id = d.id";
$conditions = [];
$params = [];

if ($mentori_id) {
    $conditions[] = "p.mentori_id = :mentori_id";
    $params[':mentori_id'] = $mentori_id;
}

if ($desiminatori_id) {
    $conditions[] = "p.desiminatori_id = :desiminatori_id";
    $params[':desiminatori_id'] = $desiminatori_id;
}

if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$projektet = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Projektet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .table th,
    .table td {
        font-size: 14px;
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1>Projektet</h1>
        <form method="get" action="projektet.php" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="desiminatori_id" class="form-label">Desiminatori:</label>
                    <select id="desiminatori_id" name="desiminatori_id" class="form-select">
                        <option value="">Të gjithë</option>
                        <?php foreach ($desiminatorët as $desiminator): ?>
                        <option value="<?= htmlspecialchars($desiminator['id']) ?>"
                            <?= $desiminatori_id == $desiminator['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($desiminator['emri'] . ' ' . $desiminator['mbiemri']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="mentori_id" class="form-label">Mentori:</label>
                    <select id="mentori_id" name="mentori_id" class="form-select">
                        <option value="">Të gjithë</option>
                        <?php foreach ($mentorët as $mentori): ?>
                        <option value="<?= htmlspecialchars($mentori['id']) ?>"
                            <?= $mentori_id == $mentori['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($mentori['emri'] . ' ' . $mentori['mbiemri']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filtro Projektet</button>
        </form>

        <!-- <a href="shto_projektet.php" class="btn btn-success mb-3">Shto Projekt</a> -->

        <table class="table table-striped table-bordered">
            <thead class="table-warning">
                <tr>
                    <th>Titulli i Projektit</th>
                    <th>Mentori</th>
                    <th>Desiminatori</th>
                    <th>Vlerësimi</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projektet as $projekti): ?>
                <tr>
                    <td><?= htmlspecialchars($projekti['titulli']) ?></td>
                    <td><?= htmlspecialchars($projekti['mentori_emri'] . ' ' . $projekti['mentori_mbiemri']) ?></td>
                    <td><?= htmlspecialchars($projekti['desiminatori_emri'] . ' ' . $projekti['desiminatori_mbiemri']) ?>
                    </td>
                    <td><?= htmlspecialchars(number_format($projekti['vleresimi'], 2)) ?></td>
                    <td>
                        <a href="./cikli_pvh.php?id=<?= htmlspecialchars($projekti['id']) ?>"
                            class="btn btn-success btn-sm">Shiko</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>