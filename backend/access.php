<?php
session_start();

function checkAccess($allowedRoleIds) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header("Location: login.php");
        exit;
    }

    $roleId = $_SESSION['role'];

    // Sigurohu që $allowedRoleIds është gjithmonë një array
    if (!is_array($allowedRoleIds)) {
        $allowedRoleIds = [$allowedRoleIds];
    }

    // Kontrollo nëse roli i përdoruesit është i lejuar
    if (!in_array($roleId, $allowedRoleIds)) {
        header("Location: noaccess.php");
        exit;
    }
}

if (!isset($_SESSION['role'])) {
    die("Nuk keni qasje!");
}

$roleId = $_SESSION['role'];

$files = [
    'vullnetaret' => 'volunteers_docs/',
    'mentoret' => 'mentors_docs/',
    'desiminatoret' => 'disseminators_docs/',
    'super_admin' => 'admin_docs/'
];

if (isset($_GET['file'])) {
    $file_path = $files[$roleId] . basename($_GET['file']);

    if (file_exists($file_path) && strpos(realpath($file_path), realpath($files[$roleId])) === 0) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        readfile($file_path);
        exit;
    } else {
        echo "Skedari nuk ekziston ose nuk keni qasje.";
    }
} else {
    echo "Nuk është përcaktuar skedari.";
}
?>