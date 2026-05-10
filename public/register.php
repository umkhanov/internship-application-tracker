<?php
require_once '../config/database.php';

if ($_POST) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    // Validasyon kontrolleri
    $errors = [];
    
    // Boş alan kontrolü
    if (empty($username) || empty($email) || empty($password)) {
        header('Location: index.php?error=4');
        exit();
    }
    
    // Kullanıcı adı uzunluk kontrolü
    if (strlen($username) < 3) {
        header('Location: index.php?error=7');
        exit();
    }
    
    // E-posta format kontrolü
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?error=5');
        exit();
    }
    
    // Şifre uzunluk kontrolü
    if (strlen($password) < 6) {
        header('Location: index.php?error=6');
        exit();
    }
    
    // Şifre eşleşme kontrolü
    if ($password !== $password_confirm) {
        header('Location: index.php?error=8');
        exit();
    }
    
    try {
        // Kullanıcı adı zaten var mı kontrol et
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            header('Location: index.php?error=2');
            exit();
        }
        
        // E-posta zaten var mı kontrol et
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            header('Location: index.php?error=3');
            exit();
        }
        
        // Şifreyi hash'le
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Yeni kullanıcı kayıt et
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password_hash]);
        
        // Otomatik giriş yap
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
        
    } catch(PDOException $e) {
        // Veritabanı hatası
        error_log("Kayıt hatası: " . $e->getMessage());
        header('Location: index.php?error=2');
        exit();
    }
} else {
    // POST verisi yoksa ana sayfaya yönlendir
    header('Location: index.php');
    exit();
}
?>