<?php
include 'access.php';
include 'db.php';
checkAccess([1, 2, 3]);

// Fetch data from oret_vullnetare
$sqlOretVullnetare = "SELECT * FROM oret_vullnetare";
$stmtOretVullnetare = $conn->prepare($sqlOretVullnetare);
$stmtOretVullnetare->execute();
$oretVullnetare = $stmtOretVullnetare->fetchAll(PDO::FETCH_ASSOC);

// Fetch data from rezultatet_e_arritura
$sqlRezultatet = "SELECT * FROM rezultatet_e_arritura";
$stmtRezultatet = $conn->prepare($sqlRezultatet);
$stmtRezultatet->execute();
$rezultatet = $stmtRezultatet->fetchAll(PDO::FETCH_ASSOC);

// Fetch data from cikli_pvh
$sqlCikliPVH = "SELECT * FROM cikli_pvh";
$stmtCikliPVH = $conn->prepare($sqlCikliPVH);
$stmtCikliPVH->execute();
$cikliPVH = $stmtCikliPVH->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
  <meta charset="UTF-8">
  <title>Shiko të Dhënat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">

    <h2 class="text-center">Të Dhënat nga Cikli PVH</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Titulli</th>
          <th>Desiminatori</th>
          <th>Vlerësimi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cikliPVH as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['titulli']) ?></td>
          <td><?= htmlspecialchars($row['desiminatori']) ?></td>
          <td><?= htmlspecialchars($row['vleresimi']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>


    <h2 class="text-center">Të Dhënat nga Rezultatet e Arritura</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Produktet</th>
          <th>Numri i Njerëzve</th>
          <th>Mjetet Financiare</th>
          <th>Gjërat Shtesë</th>
          <th>Përshkrimi i Projektit</th>
          <th>Faturat</th>
          <th>Vlerësimi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rezultatet as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['produktet']) ?></td>
          <td><?= htmlspecialchars($row['numri_njerezve']) ?></td>
          <td><?= htmlspecialchars($row['mjetet_financiare']) ?></td>
          <td><?= htmlspecialchars($row['gjera_shtes']) ?></td>
          <td><?= htmlspecialchars($row['pershkrimi_projektit']) ?></td>
          <td><?= htmlspecialchars($row['faturat']) ?></td>
          <td><?= htmlspecialchars($row['vleresimi']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>




    <h2 class="text-center">Të Dhënat nga Oret Vullnetare</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Aktivitetet Konkrete</th>
          <th>Data Fillimit</th>
          <th>Ora Fillimit</th>
          <th>Data Përfundimit</th>
          <th>Ora Përfundimit</th>
          <th>Pjesëmarrësit</th>
          <th>Vlerësimi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($oretVullnetare as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['aktivitetet_konkrete']) ?></td>
          <td><?= htmlspecialchars($row['data_fillimit']) ?></td>
          <td><?= htmlspecialchars($row['ora_fillimit']) ?></td>
          <td><?= htmlspecialchars($row['data_perfundimit']) ?></td>
          <td><?= htmlspecialchars($row['ora_perfundimit']) ?></td>
          <td><?= htmlspecialchars($row['pjesemarresit']) ?></td>
          <td><?= htmlspecialchars($row['vleresimi']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>