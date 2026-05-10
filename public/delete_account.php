<?php
require_once '../config/database.php';
checkLogin();

// Kullanıcının hesabını ve tüm başvurularını sil
try {
    // Önce kullanıcının tüm başvurularını sil (CASCADE ile otomatik silinir ama açık yapalım)
    $stmt = $pdo->prepare("DELETE FROM applications WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    
    // Sonra kullanıcı hesabını sil
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    
    // Oturumu sonlandır
    session_destroy();
    
    // Ana sayfaya başarı mesajı ile yönlendir
    header('Location: index.php?success=2');
    exit();
    
} catch(PDOException $e) {
    // Hata durumunda log'la ve hata sayfasına yönlendir
    error_log("Hesap silme hatası: " . $e->getMessage());
    header('Location: dashboard.php?error=1');
    exit();
}
?>