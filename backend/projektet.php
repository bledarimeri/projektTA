<?php
include 'access.php';
include 'db.php';
checkAccess([1, 2, 3]);

// Merr të dhënat nga tabela projektet
$sql = "SELECT p.id, p.titulli, d.emri AS desiminatori, m.emri AS mentori, p.vleresimi 
        FROM projektet p
        LEFT JOIN desiminatoret d ON p.desiminatori_id = d.id
        LEFT JOIN mentoret m ON p.mentori_id = m.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$projektet = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fshi projektin nëse është bërë një kërkesë POST për fshirje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);
    $sqlDelete = "DELETE FROM projektet WHERE id = :id";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bindParam(':id', $deleteId);
    if ($stmtDelete->execute()) {
        echo "<div class='alert alert-success'>Projekti u fshi me sukses!</div>";
    } else {
        echo "<div class='alert alert-danger'>Gabim gjatë fshirjes së projektit!</div>";
    }
    // Rifresko faqen për të përditësuar listën
    header("Location: projektet.php");
    exit;
}
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

            <!-- Butoni Shiko Projektin -->
            <a href="./shiko_te_dhenat.php?id=<?= $projekti['id'] ?>" class="btn btn-info btn-sm">Shiko Projektin</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>