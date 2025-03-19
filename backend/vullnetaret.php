<?php
include 'db.php';

// Merr të dhënat e vullnetarëve
$sql = "SELECT * FROM vullnetaret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$vullnetaret = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Vullnetarët</title>
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
    .delete {
        background-color: blue;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }

    .delete {
        background-color: red;
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
    <h1>Vullnetarët</h1>
    <table>
        <tr>
            <th>Emri</th>
            <th>Mbiemri</th>
            <th>Email-i</th>
            <th>Numri i telefonit</th>
            <th>Veprime</th>
        </tr>
        <?php foreach ($vullnetaret as $vullnetari): ?>
        <tr>
            <td><?= htmlspecialchars($vullnetari['emri']) ?></td>
            <td><?= htmlspecialchars($vullnetari['mbiemri']) ?></td>
            <td><?= htmlspecialchars($vullnetari['email']) ?></td>
            <td><?= htmlspecialchars($vullnetari['numri_telefonit']) ?></td>
            <td>
                <a href="edit_vullnetaret.php?id=<?= htmlspecialchars($vullnetari['id']) ?>" class="edit">Edit</a>
                <a href="delete_vullnetaret.php?id=<?= htmlspecialchars($vullnetari['id']) ?>" class="delete"
                    onclick="return confirm('A jeni i sigurt që doni ta fshini këtë vullnetar?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>