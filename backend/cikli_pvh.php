<?php
include 'access.php';
include 'db.php';
checkAccess([1, 2, 3]);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulli = $_POST['titulli'] ?? null;
    $desiminatori_id = $_POST['desiminatori_id'] ?? null;
    $vleresimi = $_POST['vleresimi'] ?? null;

    // Kontrollo nëse të dhënat e nevojshme janë të vendosura
    if (empty($titulli) || empty($desiminatori_id) || empty($vleresimi)) {
        echo "Ju lutemi plotësoni të gjitha fushat e kërkuara.";
        exit;
    }

    // Kontrollo nëse mentori ekziston në tabelën mentoret
    $sqlCheckDesiminator = "SELECT COUNT(*) FROM desiminatoret WHERE id = :desiminatori_id";
    $stmtCheckDesiminator = $conn->prepare($sqlCheckDesiminator);
    $stmtCheckDesiminator->bindParam(':desiminatori_id', $desiminatori_id);
    $stmtCheckDesiminator->execute();
    $desiminatoriExists = $stmtCheckDesiminator->fetchColumn();

    if (!$desiminatoriExists) {
        echo "Desiminatori i zgjedhur nuk ekziston.";
        exit;
    }

    // Ruajtja e të dhënave në tabelën cikli_pvh
    $sql_cikli = "INSERT INTO cikli_pvh (titulli, desiminatori, vleresimi)
                  VALUES (:titulli, :desiminatori_id, :vleresimi)";
    $stmt_cikli = $conn->prepare($sql_cikli);
    $stmt_cikli->bindParam(':titulli', $titulli);
    $stmt_cikli->bindParam(':desiminatori_id', $desiminatori_id);
    $stmt_cikli->bindParam(':vleresimi', $vleresimi);
    

    if ($stmt_cikli->execute()) {
        // Insert into the new table
        $sql_new_table = "INSERT INTO projektet_data (source, titulli, desiminatori, vleresimi) 
                          VALUES ('cikli_pvh', :titulli, :desiminatori_id, :vleresimi)";
        $stmt_new = $conn->prepare($sql_new_table);
        $stmt_new->bindParam(':titulli', $titulli);
        $stmt_new->bindParam(':desiminatori_id', $desiminatori_id);
        $stmt_new->bindParam(':vleresimi', $vleresimi);
        $stmt_new->execute();

        // Ruajtja e të dhënave në tabelën projektet
        $sql_projektet = "INSERT INTO projektet (titulli, desiminatori_id, vleresimi, mentori_id) 
        VALUES (:titulli, :desiminatori_id, :vleresimi, NULL)";
        $stmt_projektet = $conn->prepare($sql_projektet);
        $stmt_projektet->bindParam(':titulli', $titulli);
        $stmt_projektet->bindParam(':desiminatori_id', $desiminatori_id);
        $stmt_projektet->bindParam(':vleresimi', $vleresimi);

        if ($stmt_projektet->execute()) {
            echo "Të dhënat u ruajtën me sukses në tabelën projektet!";
            // Redirect to rezultatet_e_arritura.php
            header("Location: ./rezultatet_e_arritura.php");
            exit;
        } else {
            echo "Gabim gjatë ruajtjes së të dhënave në tabelën projektet.";
        }
    } else {
        echo "Gabim gjatë ruajtjes së të dhënave në tabelën cikli_pvh.";
    }
}

// Merr listën e desiminatorëve nga tabela desiminatoret
$sqlDesiminatoret = "SELECT id, emri FROM desiminatoret";
$stmtDesiminatoret = $conn->prepare($sqlDesiminatoret);
$stmtDesiminatoret->execute();
$desiminatoret = $stmtDesiminatoret->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="sq">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cikli PVH</title>
  <!-- Bootstrap CSS -->
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

  .form-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #007b5e;
  }

  .form-container .form-label {
    font-weight: bold;
  }

  .form-container .btn-success {
    background-color: #007b5e;
    border-color: #007b5e;
  }

  .form-container .btn-success:hover {
    background-color: #005a43;
    border-color: #005a43;
  }

  .form-container .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
  }

  .form-container .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
  }

  .form-container textarea {
    height: 10px;
    max-height: 350px;
  }

  .form-container .form-check-label {
    margin-left: 5px;
  }
  </style>
</head>

<body>
  <div class="form-container">
    <h2>Cikli PVH</h2>
    <form method="post" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
      <div class="mb-3">
        <label for="titulli" class="form-label">Titulli:</label>
        <input type="text" id="titulli" name="titulli" class="form-control" <?php if ($roleId !== 3): ?> readonly
          value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label" required> Aksioni:</label>
        <div class="form-check">
          <input type="radio" id="aksioni1" name="aksioni" value="Aksion ne komunitet" class="form-check-input"
            <?php if ($roleId !== 3): ?> disabled <?php endif; ?> required>
          <label for="aksioni1" class="form-check-label">Aksion në komunitet</label>
        </div>
        <div class="form-check">
          <input type="radio" id="aksioni2" name="aksioni" value="Aksion nder kulturor" class="form-check-input"
            <?php if ($roleId !== 3): ?> disabled <?php endif; ?> required>
          <label for="aksioni2" class="form-check-label">Aksion ndër kulturor</label>
        </div>
        <div class="form-check">
          <input type="radio" id="aksioni3" name="aksioni" value="Aksion kunder dhunes" class="form-check-input"
            <?php if ($roleId !== 3): ?> disabled <?php endif; ?> required>
          <label for="aksioni3" class="form-check-label">Aksion kundër dhunës</label>
        </div>
      </div>

      <div class="mb-3">
        <label for="dega" class="form-label">Dega e KK:</label>
        <input type="text" id="dega" name="dega" class="form-control" <?php if ($roleId !== 3): ?> readonly
          value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="desiminatori" class="form-label">Desiminatori:</label>
        <select id="desiminatori_id" name="desiminatori_id" class="form-select" required>
          <option value="">Zgjidh Desiminatorin</option>
          <?php foreach ($desiminatoret as $desiminatori): ?>
          <option value="<?= htmlspecialchars($desiminatori['id']) ?>">
            <?= htmlspecialchars($desiminatori['emri']) ?>
          </option>
          <?php endforeach; ?>
        </select>
        <small class="text-danger">Kjo fushë është e detyrueshme.</small>
      </div>


      <div class="mb-3">
        <label for="punetori" class="form-label">Punëtori:</label>
        <input type="text" id="punetori" name="punetori" class="form-control" <?php if ($roleId !== 3): ?> readonly
          value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="permbajtja_titulli" class="form-label">Përmbajtja Titulli:</label>
        <input type="text" id="permbajtja_titulli" name="permbajtja_titulli" class="form-control"
          <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="permbajtja" class="form-label">Përmbajtja:</label>
        <textarea id="permbajtja" name="permbajtja" class="form-control" rows="3" <?php if ($roleId !== 3): ?> readonly
          value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
        </textarea>
      </div>

      <div class="mb-3">
        <label for="analiza_problemit" class="form-label">Analiza e Problemit:</label>
        <textarea id="analiza_problemit" name="analiza_problemit" class="form-control" rows="3"
          <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
        </textarea>
      </div>

      <div class="mb-3">
        <label for="note" class="form-label">Note:</label>
        <textarea id="note" name="note" class="form-control" rows="3" <?php if ($roleId !== 3): ?> readonly
          value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="percaktimi" class="form-label">Përcaktimi:</label>
        <textarea id="percaktimi" name="percaktimi" class="form-control" rows="3" <?php if ($roleId !== 3): ?> readonly
          value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="perdorimi_projektit" class="form-label">Përdorimi i Projektit:</label>
        <textarea id="perdorimi_projektit" name="perdorimi_projektit" class="form-control" rows="3"
          <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
        </textarea>
      </div>

      <div class="mb-3">
        <label for="informacione_shtese" class="form-label">Informacione Shtesë:</label>
        <textarea id="informacione_shtese" name="informacione_shtese" class="form-control" rows="3"
          <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
        </textarea>
      </div>

      <div class="mb-3">
        <label for="skedaret" class="form-label">Skedarët e ngarkuar (PDF, DOCX, Images):</label>
        <input type="file" id="skedaret" name="skedaret[]" class="form-control" <?php if ($roleId !== 3): ?> readonly
          value="readonly" <?php endif; ?> required></textarea>
        <?php if ($roleId !== 3): ?>
        <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="vleresimi" class="form-label">Vlerësimi:</label>
        <input type="text" id="vleresimi" name="vleresimi" class="form-control" <?php if ($roleId !== 2): ?> readonly
          value="readonly" <?php endif; ?> required>
        <?php if ($roleId !== 2): ?>
        <small class="text-danger">Vetëm mentorët mund të plotësojnë këtë fushë.</small>
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