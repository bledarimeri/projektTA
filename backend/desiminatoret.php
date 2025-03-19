<?php
include 'db.php';

// Merr të dhënat e desiminatorëve
$sql = "SELECT * FROM desiminatoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$desiminatoret = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Desiminatorët</title>
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
    <h1>Desiminatorët</h1>
    <table>
        <tr>
            <th>Emri</th>
            <th>Mbiemri</th>
            <th>Email-i</th>
            <th>Numri i telefonit</th>
            <th>Veprime</th>
        </tr>
        <?php foreach ($desiminatoret as $desiminatori): ?>
        <tr>
            <td><?= htmlspecialchars($desiminatori['emri']) ?></td>
            <td><?= htmlspecialchars($desiminatori['mbiemri']) ?></td>
            <td><?= htmlspecialchars($desiminatori['email']) ?></td>
            <td><?= htmlspecialchars($desiminatori['numri_telefonit']) ?></td>
            <td>
                <a href="edit_desiminatoret.php?id=<?= htmlspecialchars($desiminatori['id']) ?>" class="edit">Edit</a>
                <a href="delete_desiminatoret.php?id=<?= htmlspecialchars($desiminatori['id']) ?>" class="delete" onclick="return confirm('A jeni i sigurt që doni ta fshini këtë desiminator?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>