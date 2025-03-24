<?php
include 'access.php';
include 'db.php';
checkAccess([1,3]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produktet = $_POST['produktet'];
    $numri_njerezve = $_POST['numri_njerezve'];
    $mjetet_financiare = $_POST['mjetet_financiare'];
    $gjera_shtes = $_POST['gjera_shtes'];
    $pershkrimi_projektit = $_POST['pershkrimi_projektit'];
    $vleresimi = $_POST['vleresimi'];

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
        height: 100vh;
    }

    .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 600px;
        font-size: 14px;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Rezultatet e Arritura</h2>
        <form method="post" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="produktet" class="form-label">Produktet e mbledhura:</label>
                <input type="text" id="produktet" name="produktet" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="numri_njerezve" class="form-label">Numri i njerëzve të cilëve u është ndihmuar:</label>
                <input type="text" id="numri_njerezve" name="numri_njerezve" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="mjetet_financiare" class="form-label">Gjithsej mjetet financiare:</label>
                <input type="text" id="mjetet_financiare" name="mjetet_financiare" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="gjera_shtes" class="form-label">Gjërat shtesë:</label>
                <input type="text" id="gjera_shtes" name="gjera_shtes" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="pershkrimi_projektit" class="form-label">Përshkrimi i Projektit:</label>
                <textarea id="pershkrimi_projektit" name="pershkrimi_projektit" class="form-control" required></textarea>
            </div>

            <div class="mb-3 file-upload">
                <label for="faturat" class="form-label">Ngarko Faturat (PDF, DOC, DOCX, Images):</label>
                <input type="file" id="faturat" name="faturat[]" class="form-control" multiple>
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