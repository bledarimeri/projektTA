<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO mentors (first_name, last_name, email, phone, password) VALUES (:first_name, :last_name, :email, :phone, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            echo "Mentor i regjistruar me sukses!";
        } else {
            echo "Gabim gjatë regjistrimit të mentorit.";
        }
    } else {
        echo "Password-et nuk përputhen.";
    }
}
?>