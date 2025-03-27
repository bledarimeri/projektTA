<?php
include 'access.php';
include 'db.php';
checkAccess([1, 2, 3]);

// Ruajtja e të dhënave në tabelën projektet
$sql_projektet = "INSERT INTO projektet (titulli, desiminatori_id, mentori_id, vleresimi) 
                  VALUES (:titulli, :desiminatori_id, :mentori_id, :vleresimi)";
$stmt_projektet = $conn->prepare($sql_projektet);
$stmt_projektet->bindParam(':titulli', $titulli);
$stmt_projektet->bindParam(':desiminatori_id', $desiminatori_id);
$stmt_projektet->bindParam(':mentori_id', $mentori_id);
$stmt_projektet->bindParam(':vleresimi', $vleresimi);
// $stmt_projektet->execute();

// Merr të dhënat nga tabela projektet
$sql = "SELECT p.titulli, d.emri AS desiminatori, m.emri AS mentori, p.vleresimi 
        FROM projektet p
        LEFT JOIN desiminatoret d ON p.desiminatori_id = d.id
        LEFT JOIN mentoret m ON p.mentori_id = m.id";
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projektet as $projekti): ?>
                <tr>
                    <td><?= htmlspecialchars($projekti['titulli']) ?></td>
                    <td><?= htmlspecialchars($projekti['mentori'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($projekti['desiminatori'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($projekti['vleresimi'] ?? 'N/A') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>