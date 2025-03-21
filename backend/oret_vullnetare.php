<?php
include 'access.php';
include 'db.php';
checkAccess([1,3]);


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
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;

    }

    .form-container {
        background-color: white;
        padding: 20px;
        padding-right: 50px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 600px;
        height: 100%;
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
    .form-container input[type="date"],
    .form-container input[type="time"],
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
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Oret Vullnetare</h2>
        <form method="post" action="">
            <label for="aktivitetet_konkrete">Aktivitetet konkrete:</label>
            <textarea id="aktivitetet_konkrete" name="aktivitetet_konkrete" required></textarea>

            <label for="data_fillimit">Data e fillimit:</label>
            <input type="date" id="data_fillimit" name="data_fillimit" required>

            <label for="ora_fillimit">Ora e fillimit:</label>
            <input type="time" id="ora_fillimit" name="ora_fillimit" required>

            <label for="data_perfundimit">Data e përfundimit:</label>
            <input type="date" id="data_perfundimit" name="data_perfundimit" required>

            <label for="ora_perfundimit">Ora e përfundimit:</label>
            <input type="time" id="ora_perfundimit" name="ora_perfundimit" required>

            <label for="pjesemarresit">Pjesëmarrës që e kryen aktivitetin:</label>
            <textarea id="pjesemarresit" name="pjesemarresit" required></textarea>

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