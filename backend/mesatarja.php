<?php
include 'db.php'; // Lidhja me bazën e të dhënave

// Merr vlerësimet nga tabelat përkatëse
$sql1 = "SELECT AVG(vleresimi) AS mesatarja_cikli FROM cikli_pvh";
$sql2 = "SELECT AVG(vleresimi) AS mesatarja_oret FROM oret_vullnetare";
$sql3 = "SELECT AVG(vleresimi) AS mesatarja_rezultatet FROM rezultatet_e_arritura";

$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$mesatarjaCikli = $stmt1->fetch(PDO::FETCH_ASSOC)['mesatarja_cikli'] ?? 0;

$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$mesatarjaOret = $stmt2->fetch(PDO::FETCH_ASSOC)['mesatarja_oret'] ?? 0;

$stmt3 = $conn->prepare($sql3);
$stmt3->execute();
$mesatarjaRezultatet = $stmt3->fetch(PDO::FETCH_ASSOC)['mesatarja_rezultatet'] ?? 0;

// Llogarit mesataren totale
$mesatarjaTotale = ($mesatarjaCikli + $mesatarjaOret + $mesatarjaRezultatet) / 3;

// Vendos mesataren totale në një tabelë përkatëse
$sqlInsert = "UPDATE tabela_rezultate SET mesatarja = :mesatarja WHERE id = 1"; // Përshtate WHERE sipas nevojës
$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->bindParam(':mesatarja', $mesatarjaTotale);

if ($stmtInsert->execute()) {
    echo "Mesatarja totale u përditësua me sukses!";
} else {
    echo "Gabim gjatë përditësimit të mesatares totale.";
}
?>