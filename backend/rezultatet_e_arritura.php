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
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
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
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-container label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-container input[type="text"],
    .form-container input[type="file"],
    .form-container textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-container button {
        width: 100%;
        padding: 10px;
        background-color: #007b5e;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .form-container button:hover {
        background-color: #005a43;
    }

    .form-container .actions {
        display: flex;
        justify-content: space-between;
    }

    .form-container .actions button {
        width: 48%;
    }

    .form-container .file-upload {
        display: flex;
        align-items: center;
    }

    .form-container .file-upload input[type="file"] {
        margin-left: 10px;
    }

    .form-container .file-upload p {
        margin: 0;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Rezultatet e Arritura</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="produktet">Produktet e mbledhura:</label>
            <input type="text" id="produktet" name="produktet" required>

            <label for="numri_njerezve">Numri i njerëzve të cilëve u është ndihmuar:</label>
            <input type="text" id="numri_njerezve" name="numri_njerezve" required>

            <label for="mjetet_financiare">Gjithsej mjetet financiare:</label>
            <input type="text" id="mjetet_financiare" name="mjetet_financiare" required>

            <label for="gjera_shtes">Gjërat shtesë:</label>
            <input type="text" id="gjera_shtes" name="gjera_shtes" required>

            <label for="pershkrimi_projektit">Përshkrimi i Projektit:</label>
            <textarea id="pershkrimi_projektit" name="pershkrimi_projektit" required></textarea>

            <div class="file-upload">
                <label for="faturat">Ngarko Faturat (PDF, DOC, DOCX, Images):</label>
                <input type="file" id="faturat" name="faturat[]" multiple>
            </div>

            <label for="vleresimi">Vlerësimi:</label>
            <input type="text" id="vleresimi" name="vleresimi" required>

            <div class="actions">
                <button type="submit">Dërgo</button>
                <button type="button" onclick="window.print()">Shkarko PDF</button>
            </div>
        </form>
    </div>
</body>

</html>