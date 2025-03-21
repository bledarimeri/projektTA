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

    .edit,
    .delete,
    .view {
        background-color: blue;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }

    .delete {
        background-color: red;
    }

    .view {
        background-color: green;
    }

    .edit:hover {
        background-color: #45a049;
    }

    .delete:hover {
        background-color: darkred;
    }

    .view:hover {
        background-color: darkgreen;
    }

    .report {
        margin-bottom: 20px;
        border: 1px solid black;
    }

    .report-header {
        background-color: #f2a900;
        padding: 10px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
    }

    .report-content {
        padding: 10px;
    }

    .actions {
        display: flex;
        gap: 10px;
    }
    </style>
</head>

<body>
    <h1>Raportet e desiminatorëve</h1>
    <form method="get" action="raportet.php">
        <label for="desiminator_id">Zgjidh Desiminatorin:</label>
        <select id="desiminator_id" name="desiminator_id">
            <option value="">Të gjithë</option>
            <?php foreach ($desiminatoret as $desiminator): ?>
            <option value="<?= htmlspecialchars($desiminator['id']) ?>"
                <?= $desiminator_id == $desiminator['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($desiminator['emri'] . ' ' . $desiminator['mbiemri']) ?>
            </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtro</button>
    </form>

    <a href="shto_raportet.php" class="view" style="margin-bottom: 20px; display: inline-block;">Shto Raport</a>

    <?php foreach ($raportet as $raport): ?>
    <div class="report">
        <div class="report-header">
            <span><?= htmlspecialchars($raport['titulli']) ?></span>
            <span><?= htmlspecialchars($raport['data']) ?></span>
            <span class="actions">
                <a href="edit_raportet.php?id=<?= htmlspecialchars($raport['id']) ?>" class="edit">Edit</a>
                <a href="delete_raportet.php?id=<?= htmlspecialchars($raport['id']) ?>" class="delete"
                    onclick="return confirm('A jeni i sigurt që doni ta fshini këtë raport?');">Delete</a>


                <a href="shiko_raportet.php?id=<?= htmlspecialchars($raport['id']) ?>" class="view">Shiko</a>

            </span>
        </div>
        <div class="report-content">
            <p><?= htmlspecialchars($raport['pershkrimi']) ?></p>
            <p><strong>Desiminatori:</strong> <?= htmlspecialchars($raport['emri'] . ' ' . $raport['mbiemri']) ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</body>

</html>