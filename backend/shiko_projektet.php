<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Merr të dhënat e projektit nga baza e të dhënave
    $sql = "SELECT p.id, p.titulli, p.vleresimi, m.emri AS mentori_emri, m.mbiemri AS mentori_mbiemri, d.emri AS desiminatori_emri, d.mbiemri AS desiminatori_mbiemri 
            FROM projektet p 
            JOIN mentoret m ON p.mentori_id = m.id 
            JOIN desiminatoret d ON p.desiminatori_id = d.id 
            WHERE p.id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $projekti = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$projekti) {
        echo "Projekti nuk u gjet.";
        exit;
    }
} else {
    echo "ID e projektit nuk është specifikuar.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Shiko Projektin</title>
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

    .form-container p {
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .form-container .actions {
        text-align: center;
        margin-top: 20px;
    }

    .form-container .actions a {
        background-color: #007b5e;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
    }

    .form-container .actions a:hover {
        background-color: #005a43;
    }

    .form-container .actions a.delete {
        background-color: red;
    }

    .form-container .actions a.delete:hover {
        background-color: darkred;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Shiko Projektin</h2>
        <label for="titulli">Titulli:</label>
        <p id="titulli"><?= htmlspecialchars($projekti['titulli']) ?></p>

        <label for="mentori">Mentori:</label>
        <p id="mentori"><?= htmlspecialchars($projekti['mentori_emri'] . ' ' . $projekti['mentori_mbiemri']) ?></p>

        <label for="desiminatori">Desiminatori:</label>
        <p id="desiminatori">
            <?= htmlspecialchars($projekti['desiminatori_emri'] . ' ' . $projekti['desiminatori_mbiemri']) ?></p>

        <label for="vleresimi">Vlerësimi:</label>
        <p id="vleresimi"><?= htmlspecialchars(number_format($projekti['vleresimi'], 2)) ?></p>

        <div class="actions">
            <a href="projektet.php">Kthehu te Projektet</a>
            <a href="edit_projektet.php?id=<?= htmlspecialchars($projekti['id']) ?>" class="edit">Edit</a>
            <a href="delete_projektet.php?id=<?= htmlspecialchars($projekti['id']) ?>" class="delete"
                onclick="return confirm('A jeni i sigurt që doni ta fshini këtë projekt?');">Delete</a>
        </div>

    </div>
</body>

</html>