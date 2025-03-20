<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Menu Anësore</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
    }

    .sidebar {
        width: 250px;
        background-color: #f2a900;
        padding: 20px;
        box-sizing: border-box;
    }

    .sidebar img {
        width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .sidebar h2 {
        color: black;
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar a {
        display: block;
        color: black;
        text-decoration: none;
        padding: 10px 0;
        margin: 5px 0;
        font-size: 18px;
    }

    .sidebar a:hover {
        background-color: darkcyan;
        border-radius: 5px;
    }

    .content {
        flex: 1;
        padding: 20px;
    }

    iframe {
        width: 100%;
        height: 100vh;
        border: none;
    }

    .new-sidebar {
        display: none;
        width: 250px;
        background-color: #f2a900;
        padding: 20px;
        box-sizing: border-box;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 1000;
    }

    .new-sidebar a {
        display: block;
        color: black;
        text-decoration: none;
        padding: 10px 0;
        margin: 5px 0;
        font-size: 18px;
    }

    .new-sidebar a:hover {
        background-color: darkcyan;
        border-radius: 5px;
    }

    .close-btn {
        display: block;
        text-align: left;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <img src="logo.png" alt="Logo" />
        <h2><?= htmlspecialchars(ucfirst($role)) ?></h2>
        <?php if ($role == 'superadmin'): ?>
        <a href="./backend/paneli_kontrollit.php" target="content-frame">Paneli i kontrollit</a>
        <a href="./backend/mentoret.php" target="content-frame">Mentorët</a>
        <a href="./backend/desiminatoret.php" target="content-frame">Desiminatorët</a>
        <a href="./backend/vullnetaret.php" target="content-frame">Vullnetarët</a>
        <a href="./backend/regmentoret.php" target="content-frame">Regjistro Mentor</a>
        <a href="./backend/regvullnetaret.php" target="content-frame">Regjistro Vullnetarë</a>
        <a href="./backend/regdesiminatoret.php" target="content-frame">Regjistro Desiminator</a>
        <a href="./backend/projektet.php" target="content-frame">Projektet</a>
        <a href="./backend/raportet.php" target="content-frame">Raportet</a>
        <a href="register.php" target="content-frame">Regjistro Përdorues</a>
        <a href="#" onclick="openNewSidebar()">Tjeter</a>
        <?php elseif ($role == 'mentor'): ?>
        <a href="./backend/mentoret.php" target="content-frame">Mentorët</a>
        <a href="./backend/projektet.php" target="content-frame">Projektet</a>
        <?php elseif ($role == 'desiminator'): ?>
        <a href="./backend/desiminatoret.php" target="content-frame">Desiminatorët</a>
        <a href="./backend/projektet.php" target="content-frame">Projektet</a>
        <?php elseif ($role == 'vullnetar'): ?>
        <a href="./backend/vullnetaret.php" target="content-frame">Vullnetarët</a>
        <a href="./backend/projektet.php" target="content-frame">Projektet</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <iframe name="content-frame" src="./backend/paneli_kontrollit.php"></iframe>
    </div>

    <div class="new-sidebar" id="newSidebar">
        <div class="close-btn">
            <button onclick="closeNewSidebar()">Mbyll</button>
        </div>
        <a href="./backend/cikli_pvh.php" target="content-frame">Cikli PVH</a>
        <a href="./backend/rezultatet_e_arritura.php" target="content-frame">Rezultatet e Arritura</a>
        <a href="./backend/oret_vullnetare.php" target="content-frame">Oret Vullnetare</a>
    </div>

    <script>
    function openNewSidebar() {
        document.getElementById("newSidebar").style.display = "block";
    }

    function closeNewSidebar() {
        document.getElementById("newSidebar").style.display = "none";
    }
    </script>
</body>

</html>
