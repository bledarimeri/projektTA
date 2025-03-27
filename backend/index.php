<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$roleId = $_SESSION['role'];

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
        height: 100vh;
        overflow: hidden;
    }

    .sidebar {
        width: 250px;
        background-color: #f2a900;
        padding: 20px;
        box-sizing: border-box;
        overflow-y: auto;
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
        overflow-y: auto;
    }

    iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <img src="logo.png" alt="Logo" />
        <h2><?= htmlspecialchars(ucfirst($roleId)) ?></h2>

        <!-- Superadmin Menu -->
        <?php if ($roleId == 1): ?>
        <a href="paneli_kontrollit.php" target="content-frame">Paneli i kontrollit</a>
        <a href="mentoret.php" target="content-frame">Mentorët</a>
        <a href="desiminatoret.php" target="content-frame">Desiminatorët</a>
        <a href="vullnetaret.php" target="content-frame">Vullnetarët</a>
        <a href="regmentoret.php" target="content-frame">Regjistro Mentor</a>
        <a href="regvullnetaret.php" target="content-frame">Regjistro Vullnetarë</a>
        <a href="regdesiminatoret.php" target="content-frame">Regjistro Desiminator</a>
        <a href="projektet.php" target="content-frame">Projektet</a>
        <a href="raportet.php" target="content-frame">Raportet</a>
        <a href="cikli_pvh.php" target="content-frame">Cikli Pvh</a>
        <a href="rezultatet_e_arritura.php" target="content-frame">Rezultatet e arritura</a>
        <a href="oret_vullnetare.php" target="content-frame">Oret vullnetare</a>
        <a href="register.php" target="content-frame">Regjistro Përdorues</a>

        <!-- Mentor Menu -->
        <?php elseif ($roleId == 2): ?>
        <a href="mentoret.php" target="content-frame">Mentorët</a>
        <a href="projektet.php" target="content-frame">Projektet</a>
        <a href="raportet.php" target="content-frame">Raportet</a>
        <a href="cikli_pvh.php" target="content-frame">Cikli Pvh</a>
        <a href="rezultatet_e_arritura.php" target="content-frame">Rezultatet e arritura</a>
        <a href="oret_vullnetare.php" target="content-frame">Oret vullnetare</a>

        <!-- Desiminator Menu -->
        <?php elseif ($roleId == 3): ?>
        <a href="desiminatoret.php" target="content-frame">Desiminatorët</a>
        <a href="projektet.php" target="content-frame">Projektet</a>
        <a href="raportet.php" target="content-frame">Raportet</a>
        <a href="cikli_pvh.php" target="content-frame">Cikli Pvh</a>
        <a href="rezultatet_e_arritura.php" target="content-frame">Rezultatet e arritura</a>
        <a href="oret_vullnetare.php" target="content-frame">Oret vullnetare</a>


        <!-- Vullnetar Menu -->
        <?php elseif ($roleId == 4): ?>
        <p>Nuk keni qasje në asnjë seksion.</p>
        <?php endif; ?>

        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <iframe name="content-frame" src="paneli_kontrollit.php"></iframe>
    </div>
</body>

</html>