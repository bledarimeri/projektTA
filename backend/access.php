<?php
session_start();

function checkAccess($requiredRole) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $role = $_SESSION['role'];
    if ($role != $requiredRole && $role != 'superadmin') {
        header("Location: no_access.php");
        exit;
    }
}

if (!isset($_SESSION['role'])) {
    die("Nuk keni qasje!");
}

$role = $_SESSION['role'];

// Mappimi i dosjeve sipas roleve
$files = [
    'volunteer' => 'volunteers_docs/',
    'mentor' => 'mentors_docs/',
    'disseminator' => 'disseminators_docs/',
    'super_admin' => 'admin_docs/'
];

if (isset($_GET['file'])) {
    $file_path = $files[$role] . basename($_GET['file']);

    // Kontrollo nëse skedari ekziston dhe nuk lejon qasje jashtë dosjes
    if (file_exists($file_path) && strpos(realpath($file_path), realpath($files[$role])) === 0) {
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