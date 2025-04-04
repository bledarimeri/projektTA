<?php
// filepath: c:\xampp\htdocs\projektTA\backend\shiko_projektin.php
include 'access.php';
include 'db.php';
checkAccess([1, 2, 3]);

// Kontrollo nëse ID-ja është dërguar në URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID e projektit mungon.";
    exit;
}

$projekti_id = intval($_GET['id']);

// Merr të dhënat e projektit nga tabela cikli_pvh
$sql = "SELECT titulli, desiminatori, vleresimi, permbajtja_titulli, permbajtja, analiza_problemit, perdorimi_projektit, informacione_shtese 
        FROM cikli_pvh
        WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $projekti_id);
$stmt->execute();
$projekti = $stmt->fetch(PDO::FETCH_ASSOC);

// Kontrollo nëse projekti ekziston
if (!$projekti) {
    echo "Projekti nuk u gjet.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shiko Projektin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <h2>Detajet e Projektit</h2>
    <table class="table table-bordered">
      <tr>
        <th>Titulli</th>
        <td><?= htmlspecialchars($projekti['titulli']) ?></td>
      </tr>
      <tr>
        <th>Desiminatori</th>
        <td><?= htmlspecialchars($projekti['desiminatori']) ?></td>
      </tr>
      <tr>
        <th>Vlerësimi</th>
        <td><?= htmlspecialchars($projekti['vleresimi']) ?></td>
      </tr>
      <tr>
        <th>Përmbajtja e Titullit</th>
        <td><?= htmlspecialchars($projekti['permbajtja_titulli']) ?></td>
      </tr>
      <tr>
        <th>Përmbajtja</th>
        <td><?= htmlspecialchars($projekti['permbajtja']) ?></td>
      </tr>
      <tr>
        <th>Analiza e Problemit</th>
        <td><?= htmlspecialchars($projekti['analiza_problemit']) ?></td>
      </tr>
      <tr>
        <th>Përdorimi i Projektit</th>
        <td><?= htmlspecialchars($projekti['perdorimi_projektit']) ?></td>
      </tr>
      <tr>
        <th>Informacione Shtesë</th>
        <td><?= htmlspecialchars($projekti['informacione_shtese']) ?></td>
      </tr>
    </table>
    <a href="projektet.php" class="btn btn-secondary">Kthehu te Lista e Projekteve</a>
  </div>
</body>

</html>