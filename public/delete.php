<?php
require_once '../config/database.php';
checkLogin();

$id = $_GET['id'] ?? 0;

// Kullanıcının kendi başvurusunu sil
$stmt = $pdo->prepare("DELETE FROM applications WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

// Ana sayfaya geri dön
header('Location: dashboard.php');
exit();
?>