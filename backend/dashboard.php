<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h2>Mirësevini, <?php echo htmlspecialchars($role); ?></h2>

    <ul>
        <?php if ($role === 'volunteer'): ?>
        <li><a href="access.php?file=volunteer_guide.pdf">Shkarko Udhëzuesin e Vullnetarit</a></li>
        <?php endif; ?>

        <?php if ($role === 'mentor'): ?>
        <li><a href="access.php?file=mentor_material.pdf">Materiale për Mentorë</a></li>
        <?php endif; ?>

        <?php if ($role === 'disseminator'): ?>
        <li><a href="access.php?file=disseminator_report.pdf">Raportet e Diseminatorëve</a></li>
        <?php endif; ?>

        <?php if ($role === 'super_admin'): ?>
        <li><a href="access.php?file=admin_report.pdf">Raporti i Super Adminit</a></li>
        <li><a href="manage_users.php">Menaxho Përdoruesit</a></li>
        <?php endif; ?>
    </ul>

    <a href="logout.php">Dil</a>
</body>

</html>