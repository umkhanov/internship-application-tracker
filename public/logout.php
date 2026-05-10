<?php
session_start();
// Oturumu sonlandır ve ana sayfaya yönlendir
session_destroy();
header('Location: index.php');
exit();
?>