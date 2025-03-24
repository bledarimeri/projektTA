<?php 
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_admin'])) {
    // Merr të dhënat nga forma
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $role = htmlspecialchars($_POST['role']);
    $message = htmlspecialchars($_POST['message']);

    // Ruaj të dhënat në bazën e të dhënave
    $sql = "INSERT INTO contact_requests (username, email, role, message) VALUES (:username, :email, :role, :message)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        $success = "Kërkesa juaj për rolin '$role' është regjistruar. Admini do të kontaktojë së shpejti.";
    } else {
        $error = "Ndodhi një gabim gjatë regjistrimit të kërkesës. Ju lutemi provoni përsëri.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Kontakto Adminin</title>
    <style>
    /* Stilizimi ekzistues */
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
        width: 300px;
        padding: 50px;
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
    .form-container input[type="email"],
    .form-container textarea,
    .form-container select {
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

    .form-container .success {
        color: green;
        text-align: center;
        margin-bottom: 10px;
    }

    .form-container .error {
        color: red;
        text-align: center;
        margin-bottom: 10px;
    }

    /* Stilizimi për butonin "Kthehu" */
    .form-container .back-btn {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #f2a900;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 10px;
    }

    .form-container .back-btn:hover {
        background-color: #d18b00;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Kontakto Adminin</h2>
        <?php if (isset($success)): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="role">Roli i kërkuar:</label>
            <select id="role" name="role" required>
                <option value="mentor">Mentor</option>
                <option value="desiminator">Desiminator</option>
                <option value="vullnetar">Vullnetar</option>
            </select>

            <label for="message">Mesazhi:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit" name="contact_admin">Dërgo Kërkesën</button>
            <a href="./login.php" class="back-btn">Kthehu</a>
        </form>
    </div>
</body>

</html>