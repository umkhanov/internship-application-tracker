<?php
require_once '../config/database.php';
checkLogin();

$id = $_GET['id'] ?? 0;

// Kullanıcının kendi başvurusunu getir
$stmt = $pdo->prepare("SELECT * FROM applications WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$app = $stmt->fetch();

// Başvuru bulunamazsa ana sayfaya yönlendir
if (!$app) {
    header('Location: dashboard.php');
    exit();
}

if ($_POST) {
    // Başvuru bilgilerini güncelle
    $stmt = $pdo->prepare("UPDATE applications SET company_name = ?, position = ?, status = ?, apply_date = ?, notes = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([
        $_POST['company_name'],
        $_POST['position'],
        $_POST['status'],
        $_POST['apply_date'],
        $_POST['notes'],
        $id,
        $_SESSION['user_id']
    ]);
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Başvuru Düzenle</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">← Geri Dön</a>
            <span class="text-white">Başvuru Düzenle</span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Başvuru Bilgilerini Düzenle</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Şirket Adı *</label>
                                <input type="text" class="form-control" name="company_name" value="<?= htmlspecialchars($app['company_name']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Pozisyon *</label>
                                <input type="text" class="form-control" name="position" value="<?= htmlspecialchars($app['position']) ?>" required>
                            </div>
                                                        
                            <div class="mb-3">
                                <label class="form-label">Başvuru Tarihi *</label>
                                <input type="date" class="form-control" name="apply_date" value="<?= $app['apply_date'] ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Notlar</label>
                                <textarea class="form-control" name="notes" rows="3"><?= htmlspecialchars($app['notes']) ?></textarea>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="dashboard.php" class="btn btn-secondary">İptal</a>
                                <button type="submit" class="btn btn-primary">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>