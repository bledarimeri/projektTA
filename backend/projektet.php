<?php
include 'access.php';
include 'db.php';
checkAccess([1, 2, 3]);

// Merr të dhënat nga tabela projektet
$sql = "SELECT * FROM projektet";
$stmt = $conn->prepare($sql);
$stmt->execute();
$projektet = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projektet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Lista e Projekteve</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titulli</th>
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
                    <td><?= htmlspecialchars($projekti['mentori'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($projekti['desiminatori'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($projekti['vleresimi'] ?? 'N/A') ?></td>
                    <td>
                        <a href="cikli_pvh.php?id=<?= $projekti['id'] ?>" class="btn btn-primary">Shiko Projektin</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>