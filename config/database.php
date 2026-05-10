<?php
session_start();

// Veritabanı bağlantı ayarları - HOSTING
$host = 'localhost';
$dbname = 'dbstorage22360859374';
$username = 'username';
$password = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

// Kullanıcı giriş kontrolü fonksiyonu
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }
}
?>
