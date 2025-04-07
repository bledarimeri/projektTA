<?php
include 'access.php';
include 'db.php';
checkAccess([1, 2, 3]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Merr të dhënat nga forma ose vendos vlera të paracaktuara
    $produktet = $_POST['produktet'] ?? null;
    $numri_njerezve = $_POST['numri_njerezve'] ?? null;
    $mjetet_financiare = $_POST['mjetet_financiare'] ?? null;
    $gjera_shtes = $_POST['gjera_shtes'] ?? null;
    $pershkrimi_projektit = $_POST['pershkrimi_projektit'] ?? null;
    $vleresimi = $_POST['vleresimi'] ?? null;

    // Kontrollo nëse të gjitha fushat e kërkuara janë plotësuar
    if (empty($produktet) || empty($numri_njerezve) || empty($mjetet_financiare) || empty($gjera_shtes) || empty($pershkrimi_projektit) || empty($vleresimi)) {
        echo "Ju lutemi plotësoni të gjitha fushat e kërkuara.";
        exit;
    }

    // Përpunimi i ngarkimit të skedarëve
    $faturat = [];
    if (!empty($_FILES['faturat']['name'][0])) {
        foreach ($_FILES['faturat']['name'] as $key => $name) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($name);
            if (move_uploaded_file($_FILES['faturat']['tmp_name'][$key], $target_file)) {
                $faturat[] = $target_file;
            }
        }
    }
    $faturat_json = json_encode($faturat);

    // Ruajtja e të dhënave në bazën e të dhënave
    $sql = "INSERT INTO rezultatet_e_arritura (produktet, numri_njerezve, mjetet_financiare, gjera_shtes, pershkrimi_projektit, faturat, vleresimi) 
            VALUES (:produktet, :numri_njerezve, :mjetet_financiare, :gjera_shtes, :pershkrimi_projektit, :faturat, :vleresimi)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':produktet', $produktet);
    $stmt->bindParam(':numri_njerezve', $numri_njerezve);
    $stmt->bindParam(':mjetet_financiare', $mjetet_financiare);
    $stmt->bindParam(':gjera_shtes', $gjera_shtes);
    $stmt->bindParam(':pershkrimi_projektit', $pershkrimi_projektit);
    $stmt->bindParam(':faturat', $faturat_json);
    $stmt->bindParam(':vleresimi', $vleresimi);

    if ($stmt->execute()) {
        // Insert into the new table
        $sql_new_table = "INSERT INTO projektet_data (source, produktet, numri_njerezve, mjetet_financiare, gjera_shtes, pershkrimi_projektit, faturat, vleresimi) 
                          VALUES ('rezultatet_e_arritura', :produktet, :numri_njerezve, :mjetet_financiare, :gjera_shtes, :pershkrimi_projektit, :faturat, :vleresimi)";
        $stmt_new = $conn->prepare($sql_new_table);
        $stmt_new->bindParam(':produktet', $produktet);
        $stmt_new->bindParam(':numri_njerezve', $numri_njerezve);
        $stmt_new->bindParam(':mjetet_financiare', $mjetet_financiare);
        $stmt_new->bindParam(':gjera_shtes', $gjera_shtes);
        $stmt_new->bindParam(':pershkrimi_projektit', $pershkrimi_projektit);
        $stmt_new->bindParam(':faturat', $faturat_json);
        $stmt_new->bindParam(':vleresimi', $vleresimi);
        $stmt_new->execute();

        // Ridrejto te faqja tjetër pas ruajtjes së suksesshme
        header("Location: ./oret_vullnetare.php?success=1");
        exit;
    } else {
        echo "Gabim gjatë ruajtjes së të dhënave.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
  <meta charset="UTF-8">
  <title>Rezultatet e Arritura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: auto;
    width: auto;
  }

  .form-container .mb3 {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 600px;
    font-size: 14px;
    height: 100%;
  }

  .form-container textarea {
    height: 10px;
    max-height: 350px;
  }

  .form-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #007b5e;
  }
  </style>
</head>

<body>
  <div class="form-container">
    <h2>Rezultatet e Arritura</h2>
    <form method="post" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
      <div class="mb-3">
        <label for="produktet" class="form-label">Produktet e mbledhura:</label>
        <input type="text" id="produktet" name="produktet" class="form-control" <?php if ($roleId !== 3): ?> readonly
          value="readonly" <?php endif; ?> required>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="numri_njerezve" class="form-label">Numri i njerëzve të cilëve u është ndihmuar:</label>
        <input type="text" id="numri_njerezve" name="numri_njerezve" class="form-control" <?php if ($roleId !== 3): ?>
          readonly value="readonly" <?php endif; ?> required>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="mjetet_financiare" class="form-label">Gjithsej mjetet financiare:</label>
        <input type="text" id="mjetet_financiare" name="mjetet_financiare" class="form-control"
          <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="gjera_shtes" class="form-label">Gjërat shtesë:</label>
        <input type="text" id="gjera_shtes" name="gjera_shtes" class="form-control" <?php if ($roleId !== 3): ?>
          readonly value="readonly" <?php endif; ?> required>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="pershkrimi_projektit" class="form-label">Përshkrimi i Projektit:</label>
        <textarea id="pershkrimi_projektit" name="pershkrimi_projektit" class="form-control"
          <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="faturat" class="form-label">Ngarko Faturat (PDF, DOC, DOCX, Images):</label>
        <input type="file" id="faturat" name="faturat[]" class="form-control" <?php if ($roleId !== 3): ?> readonly
          value="readonly" <?php endif; ?> required>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="vleresimi" class="form-label">Vlerësimi:</label>
        <input type="text" id="vleresimi" name="vleresimi" class="form-control" <?php if ($roleId !== 2): ?> readonly
          value="readonly" <?php endif; ?> required>
        <?php if ($roleId !== 2): ?>
        <small class="text-danger">Vetëm mentoret mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-success">Dërgo</button>
        <button type="button" class="btn btn-secondary" onclick="window.print()">Shkarko PDF</button>
        <a href="shiko_projektet.php" class="btn btn-primary">Shiko Projektet</a>
      </div>
    </form>
  </div>
</body>

</html>