<?php
require_once '../config/database.php';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Boş alan kontrolü
    if (empty($username) || empty($password)) {
        header('Location: index.php?error=4');
        exit();
    }
    
    try {
        // Kullanıcıyı veritabanından kontrol et
        $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        // Şifre doğrulama ve oturum başlatma
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header('Location: dashboard.php');
            exit();
        } else {
            header('Location: index.php?error=1');
            exit();
        }
        
    } catch(PDOException $e) {
        // Veritabanı hatası
        error_log("Giriş hatası: " . $e->getMessage());
        header('Location: index.php?error=1');
        exit();
    }
    
} else {
    // POST verisi yoksa ana sayfaya yönlendir
    header('Location: index.php');
    exit();
}
?>