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
    <title>Cikli PVH</title>
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
        padding-right: 50px;
        margin: auto;
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
    .form-container textarea,
    .form-container select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-container input[type="radio"] {
        margin-right: 10px;
    }

    .form-container .radio-group {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
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
        <h2>Cikli PVH</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="titulli">Titulli:</label>
            <input type="text" id="titulli" name="titulli" required>

            <div class="radio-group">
                <label>
                    <input type="radio" name="aksioni" value="Aksion ne komunitet" required> Aksion në komunitet
                </label>
                <label>
                    <input type="radio" name="aksioni" value="Aksion nder kulturor" required> Aksion ndër kulturor
                </label>
                <label>
                    <input type="radio" name="aksioni" value="Aksion kunder dhunes" required> Aksion kundër dhunës
                </label>
            </div>

            <label for="dega">Dega e KK:</label>
            <input type="text" id="dega" name="dega" required>

            <label for="desiminatori">Desiminatori:</label>
            <select id="desiminatori" name="desiminatori" required>
                <option value="">Select Teacher</option>

            </select>

            <label for="punetori">Punëtori:</label>
            <input type="text" id="punetori" name="punetori" required>

            <label for="permbajtja_titulli">Përmbajtja Titulli:</label>
            <input type="text" id="permbajtja_titulli" name="permbajtja_titulli" required>

            <label for="permbajtja">Përmbajtja:</label>
            <textarea id="permbajtja" name="permbajtja" required></textarea>

            <label for="analiza_problemit">Analiza e Problemit:</label>
            <textarea id="analiza_problemit" name="analiza_problemit" required></textarea>

            <label for="note">Note:</label>
            <textarea id="note" name="note" required></textarea>

            <label for="percaktimi">Përcaktimi:</label>
            <textarea id="percaktimi" name="percaktimi" required></textarea>

            <label for="perdorimi_projektit">Përdorimi i Projektit:</label>
            <textarea id="perdorimi_projektit" name="perdorimi_projektit" required></textarea>

            <label for="informacione_shtese">Informacione Shtesë:</label>
            <textarea id="informacione_shtese" name="informacione_shtese" required></textarea>

            <div class="file-upload">
                <label for="skedaret">Skedarët e ngarkuar (PDF, DOCX, Images):</label>
                <input type="file" id="skedaret" name="skedaret[]" multiple>
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