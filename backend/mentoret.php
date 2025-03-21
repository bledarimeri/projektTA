<?php
include 'access.php';
checkAccess(['mentoret', 'superadmin']); // Lejo qasje për mentorët dhe superadminët

include 'db.php';

// Merr të dhënat e mentorëve
$sql = "SELECT * FROM mentoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$mentoret = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Mentorët</title>
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
    <h1>Mentorët</h1>
    <table>
        <tr>
            <th>Emri</th>
            <th>Mbiemri</th>
            <th>Email-i</th>
            <th>Numri i telefonit</th>
            <th>Veprime</th>
        </tr>
        <?php foreach ($mentoret as $mentori): ?>
        <tr>
            <td><?= htmlspecialchars($mentori['emri']) ?></td>
            <td><?= htmlspecialchars($mentori['mbiemri']) ?></td>
            <td><?= htmlspecialchars($mentori['email']) ?></td>
            <td><?= htmlspecialchars($mentori['numri_telefonit']) ?></td>
            <td>
                <a href="edit_mentoret.php?id=<?= htmlspecialchars($mentori['id']) ?>" class="edit">Edit</a>
                <a href="delete_mentoret.php?id=<?= htmlspecialchars($mentori['id']) ?>" class="delete"
                    onclick="return confirm('A jeni i sigurt që doni ta fshini këtë mentor?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>