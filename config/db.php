<?php
$host = "localhost";
$user = "root"; // atau sesuai server kamu
$pass = "";
$db   = "compon";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
