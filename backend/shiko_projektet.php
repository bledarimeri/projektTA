<?php
include 'access.php';
include 'db.php';
checkAccess([1, 2, 3]);

// Fetch data from the new table
$sql = "SELECT * FROM projektet_data";
$stmt = $conn->prepare($sql);
$stmt->execute();
$projektet = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update data logic
    $id = $_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'];

    $sql_update = "UPDATE projektet_data SET $field = :value WHERE id = :id";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bindParam(':value', $value);
    $stmt_update->bindParam(':id', $id);
    if ($stmt_update->execute()) {
        echo "Të dhënat u përditësuan me sukses!";
    } else {
        echo "Gabim gjatë përditësimit të të dhënave.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
  <meta charset="UTF-8">
  <title>Shiko Projektet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <h2>Shiko dhe Edito Projektet</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Burimi</th>
          <th>Fusha</th>
          <th>Vlera</th>
          <th>Veprim</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($projektet as $projekti): ?>
        <tr>
          <form method="post" action="">
            <td><?= htmlspecialchars($projekti['id']) ?></td>
            <td><?= htmlspecialchars($projekti['source']) ?></td>
            <td>
              <input type="text" name="field" class="form-control" required>
            </td>
            <td>
              <input type="text" name="value" class="form-control" required>
            </td>
            <td>
              <input type="hidden" name="id" value="<?= htmlspecialchars($projekti['id']) ?>">
              <button type="submit" class="btn btn-primary">Ruaj</button>
            </td>
          </form>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>