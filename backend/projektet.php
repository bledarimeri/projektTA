<?php

include 'access.php';
checkAccess(['mentor', 'desiminator', 'superadmin']); // Lejo qasje për mentorët, desiminatorët dhe superadminët

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
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2a900;
    }

    .view,
    .edit,
    .delete {
        background-color: green;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }

    .edit {
        background-color: blue;
    }

    .delete {
        background-color: red;
    }

    .view:hover {
        background-color: darkgreen;
    }

    .edit:hover {
        background-color: #45a049;
    }

    .delete:hover {
        background-color: darkred;
    }
    </style>
</head>

<body>
    <h1>Projektet</h1>
    <form method="get" action="projektet.php">
        <label for="desiminatori_id">Desiminatori:</label>
        <select id="desiminatori_id" name="desiminatori_id">
            <option value="">Të gjithë</option>
            <?php foreach ($desiminatorët as $desiminator): ?>
            <option value="<?= htmlspecialchars($desiminator['id']) ?>"
                <?= $desiminatori_id == $desiminator['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($desiminator['emri'] . ' ' . $desiminator['mbiemri']) ?>
            </option>
            <?php endforeach; ?>
        </select>
        <label for="mentori_id">Mentori:</label>
        <select id="mentori_id" name="mentori_id">
            <option value="">Të gjithë</option>
            <?php foreach ($mentorët as $mentori): ?>
            <option value="<?= htmlspecialchars($mentori['id']) ?>"
                <?= $mentori_id == $mentori['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($mentori['emri'] . ' ' . $mentori['mbiemri']) ?>
            </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtro Projektet</button>
    </form>

    <a href="shto_projektet.php" class="view" style="margin-bottom: 20px; display: inline-block;">Shto Projekt</a>

    <table>
        <tr>
            <th>Titulli i Projektit</th>
            <th>Mentori</th>
            <th>Desiminatori</th>
            <th>Vlerësimi (Mesatarja)</th>
            <th>Veprime</th>
        </tr>
        <?php foreach ($projektet as $projekti): ?>
        <tr>
            <td><?= htmlspecialchars($projekti['titulli']) ?></td>
            <td><?= htmlspecialchars($projekti['mentori_emri'] . ' ' . $projekti['mentori_mbiemri']) ?></td>
            <td><?= htmlspecialchars($projekti['desiminatori_emri'] . ' ' . $projekti['desiminatori_mbiemri']) ?></td>
            <td><?= htmlspecialchars(number_format($projekti['vleresimi'], 2)) ?></td>
            <td>
                <a href="shiko_projektet.php?id=<?= htmlspecialchars($projekti['id']) ?>" class="view">Shiko
                    Projektin</a>

            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>