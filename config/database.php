<?php
$host = "localhost";
$dbname = "immanuel_library";
$username = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

$options = [

    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//untuk eror mode jika ada eror

    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //buat inputan dalam default aray asosiatif

    PDO::ATTR_EMULATE_PREPARES => false//agar inputan tipe data tetap normal sesuai input tidak string
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $error) {
    die("Koneksi ke database gagal: " . $error->getMessage());
}