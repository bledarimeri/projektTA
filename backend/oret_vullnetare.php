<?php
include 'access.php';
include 'db.php';
checkAccess([1,2,3]);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aktivitetet_konkrete = $_POST['aktivitetet_konkrete'];
    $data_fillimit = $_POST['data_fillimit'];
    $ora_fillimit = $_POST['ora_fillimit'];
    $data_perfundimit = $_POST['data_perfundimit'];
    $ora_perfundimit = $_POST['ora_perfundimit'];
    $pjesemarresit = $_POST['pjesemarresit'];
    $vleresimi = $_POST['vleresimi'];

    $sql = "INSERT INTO oret_vullnetare (aktivitetet_konkrete, data_fillimit, ora_fillimit, data_perfundimit, ora_perfundimit, pjesemarresit, vleresimi) 
            VALUES (:aktivitetet_konkrete, :data_fillimit, :ora_fillimit, :data_perfundimit, :ora_perfundimit, :pjesemarresit, :vleresimi)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':aktivitetet_konkrete', $aktivitetet_konkrete);
    $stmt->bindParam(':data_fillimit', $data_fillimit);
    $stmt->bindParam(':ora_fillimit', $ora_fillimit);
    $stmt->bindParam(':data_perfundimit', $data_perfundimit);
    $stmt->bindParam(':ora_perfundimit', $ora_perfundimit);
    $stmt->bindParam(':pjesemarresit', $pjesemarresit);
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
    <title>Oret Vullnetare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: top;
        height: 160vh;
        width: auto;
        padding-top: 50px;


    }

    .form-container .mb3 {
        background-color: white;
        padding: p0;
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

    .form-container textarea {
        height: 10px;
        max-height: 350px;


    }

    .form-container .form-label {
        font-weight: bold;
    }

    .form-control {
        margin-bottom: 20px;
        width: 100%;
        margin-right: 30px;
        padding-left: 70px;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Oret Vullnetare</h2>
        <form method="post" action="" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="aktivitetet_konkrete" class="form-label">Aktivitetet konkrete:</label>
                <textarea id="aktivitetet_konkrete" name="aktivitetet_konkrete" class="form-control"
                    <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
                <?php if ($roleId !== 3): ?>
                <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
                <?php endif; ?>
                </textarea>
            </div>

            <div class="mb-3">
                <label for="data_fillimit" class="form-label">Data e fillimit:</label>
                <input type="date" id="data_fillimit" name="data_fillimit" class="form-control"
                    <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
                <?php if ($roleId !== 3): ?>
                <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
                <?php endif; ?>

            </div>

            <div class="mb-3">
                <label for="ora_fillimit" class="form-label">Ora e fillimit:</label>
                <input type="time" id="ora_fillimit" name="ora_fillimit" class="form-control"
                    <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
                <?php if ($roleId !== 3): ?>
                <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
                <?php endif; ?>

            </div>

            <div class="mb-3">
                <label for="data_perfundimit" class="form-label">Data e përfundimit:</label>
                <input type="date" id="data_perfundimit" name="data_perfundimit" class="form-control"
                    <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
                <?php if ($roleId !== 3): ?>
                <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
                <?php endif; ?>

            </div>

            <div class="mb-3">
                <label for="ora_perfundimit" class="form-label">Ora e përfundimit:</label>
                <input type="time" id="ora_perfundimit" name="ora_perfundimit" class="form-control"
                    <?php if ($roleId !== 3): ?> readonly value="readonly" <?php endif; ?> required></textarea>
                <?php if ($roleId !== 3): ?>
                <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
                <?php endif; ?>

            </div>

            <div class="mb-3">
                <label for="pjesemarresit" class="form-label">Pjesëmarrës që e kryen aktivitetin:</label>
                <textarea id="pjesemarresit" name="pjesemarresit" class="form-control" <?php if ($roleId !== 3): ?>
                    readonly value="readonly" <?php endif; ?> required></textarea>
                <?php if ($roleId !== 3): ?>
                <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
                <?php endif; ?>
                </textarea>
            </div>

            <div class="mb-3">
                <label for="vleresimi" class="form-label">Vlerësimi:</label>
                <input type="text" id="vleresimi" name="vleresimi" class="form-control" <?php if ($roleId !== 2): ?>
                    readonly value="readonly" <?php endif; ?> required></textarea>
                <?php if ($roleId !== 2): ?>
                <small class="text-danger">Vetëm desiminatorët mund të plotësojnë këtë fushë.</small>
                <?php endif; ?>

            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Dërgo</button>
                <button type="button" class="btn btn-secondary" onclick="window.print()">Shkarko PDF</button>
            </div>
        </form>
    </div>
</body>

</html>