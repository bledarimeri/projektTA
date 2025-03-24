<?php
include 'access.php';
include 'db.php';
checkAccess([1,3]);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulli = $_POST['titulli'];
    $aksioni = $_POST['aksioni'];
    $dega = $_POST['dega'];
    $desiminatori = $_POST['desiminatori'];
    $punetori = $_POST['punetori'];
    $permbajtja_titulli = $_POST['permbajtja_titulli'];
    $permbajtja = $_POST['permbajtja'];
    $analiza_problemit = $_POST['analiza_problemit'];
    $note = $_POST['note'];
    $percaktimi = $_POST['percaktimi'];
    $perdorimi_projektit = $_POST['perdorimi_projektit'];
    $informacione_shtese = $_POST['informacione_shtese'];
    $vleresimi = $_POST['vleresimi'];

    // Përpunimi i ngarkimit të skedarëve
    $skedaret = [];
    if (!empty($_FILES['skedaret']['name'][0])) {
        foreach ($_FILES['skedaret']['name'] as $key => $name) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($name);
            if (move_uploaded_file($_FILES['skedaret']['tmp_name'][$key], $target_file)) {
                $skedaret[] = $target_file;
            }
        }
    }
    $skedaret_json = json_encode($skedaret);

    $sql = "INSERT INTO cikli_pvh (titulli, aksioni, dega, desiminatori, punetori, permbajtja_titulli, permbajtja, analiza_problemit, note, percaktimi, perdorimi_projektit, informacione_shtese, skedaret, vleresimi) 
            VALUES (:titulli, :aksioni, :dega, :desiminatori, :punetori, :permbajtja_titulli, :permbajtja, :analiza_problemit, :note, :percaktimi, :perdorimi_projektit, :informacione_shtese, :skedaret, :vleresimi)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titulli', $titulli);
    $stmt->bindParam(':aksioni', $aksioni);
    $stmt->bindParam(':dega', $dega);
    $stmt->bindParam(':desiminatori', $desiminatori);
    $stmt->bindParam(':punetori', $punetori);
    $stmt->bindParam(':permbajtja_titulli', $permbajtja_titulli);
    $stmt->bindParam(':permbajtja', $permbajtja);
    $stmt->bindParam(':analiza_problemit', $analiza_problemit);
    $stmt->bindParam(':note', $note);
    $stmt->bindParam(':percaktimi', $percaktimi);
    $stmt->bindParam(':perdorimi_projektit', $perdorimi_projektit);
    $stmt->bindParam(':informacione_shtese', $informacione_shtese);
    $stmt->bindParam(':skedaret', $skedaret_json);
    $stmt->bindParam(':vleresimi', $vleresimi);

    if ($stmt->execute()) {
        echo "Të dhënat u ruajtën me sukses!";
    } else {
        echo "Gabim gjatë ruajtjes së të dhënave.";
    }
}
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
        min-height: 100vh;
    }

    .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 800px;
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
        resize: none;
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
                <input type="text" id="titulli" name="titulli" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Aksioni:</label>
                <div class="form-check">
                    <input type="radio" id="aksioni1" name="aksioni" value="Aksion ne komunitet"
                        class="form-check-input" required>
                    <label for="aksioni1" class="form-check-label">Aksion në komunitet</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="aksioni2" name="aksioni" value="Aksion nder kulturor"
                        class="form-check-input" required>
                    <label for="aksioni2" class="form-check-label">Aksion ndër kulturor</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="aksioni3" name="aksioni" value="Aksion kunder dhunes"
                        class="form-check-input" required>
                    <label for="aksioni3" class="form-check-label">Aksion kundër dhunës</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="dega" class="form-label">Dega e KK:</label>
                <input type="text" id="dega" name="dega" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="desiminatori" class="form-label">Desiminatori:</label>
                <select id="desiminatori" name="desiminatori" class="form-select" required>
                    <option value="">Zgjidh Desiminatorin</option>
                    <option value="Desiminatori 1">Desiminatori 1</option>
                    <option value="Desiminatori 2">Desiminatori 2</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="punetori" class="form-label">Punëtori:</label>
                <input type="text" id="punetori" name="punetori" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="permbajtja_titulli" class="form-label">Përmbajtja Titulli:</label>
                <input type="text" id="permbajtja_titulli" name="permbajtja_titulli" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="permbajtja" class="form-label">Përmbajtja:</label>
                <textarea id="permbajtja" name="permbajtja" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="analiza_problemit" class="form-label">Analiza e Problemit:</label>
                <textarea id="analiza_problemit" name="analiza_problemit" class="form-control" rows="3"
                    required></textarea>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note:</label>
                <textarea id="note" name="note" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="percaktimi" class="form-label">Përcaktimi:</label>
                <textarea id="percaktimi" name="percaktimi" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="perdorimi_projektit" class="form-label">Përdorimi i Projektit:</label>
                <textarea id="perdorimi_projektit" name="perdorimi_projektit" class="form-control" rows="3"
                    required></textarea>
            </div>

            <div class="mb-3">
                <label for="informacione_shtese" class="form-label">Informacione Shtesë:</label>
                <textarea id="informacione_shtese" name="informacione_shtese" class="form-control" rows="3"
                    required></textarea>
            </div>

            <div class="mb-3">
                <label for="skedaret" class="form-label">Skedarët e ngarkuar (PDF, DOCX, Images):</label>
                <input type="file" id="skedaret" name="skedaret[]" class="form-control" multiple>
            </div>

            <div class="mb-3">
                <label for="vleresimi" class="form-label">Vlerësimi:</label>
                <input type="text" id="vleresimi" name="vleresimi" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Dërgo</button>
                <button type="button" class="btn btn-secondary" onclick="window.print()">Shkarko PDF</button>
            </div>
        </form>
    </div>
</body>

</html>