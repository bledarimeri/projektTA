<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        $success = "Përdoruesi u regjistrua me sukses!";
    } else {
        $error = "Gabim gjatë regjistrimit të përdoruesit.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Regjistro Përdorues</title>
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
    .form-container input[type="password"],
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

    .form-container .login-btn {
        background-color: #f2a900;
        margin-top: 10px;
        padding: 10px 50px;
    }

    .form-container .login-btn:hover {
        background-color: #d18b00;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Regjistro Përdorues</h2>
        <?php if (isset($success)): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Roli:</label>
            <select id="role" name="role" required>
                <option value="vullnetar">Vullnetar</option>
                <option value="mentor">Mentor</option>
                <option value="desiminator">Desiminator</option>
                <option value="superadmin">Superadmin</option>
            </select>

            <button type="submit">Regjistro</button>
        </form>
        <button class="login-btn"><a href="./login.php">Kthehu</a></button>
    </div>
</body>

</html>