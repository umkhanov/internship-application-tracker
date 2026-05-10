<?php
require_once '../config/database.php';
checkLogin();

if ($_POST) {
    // Yeni başvuru ekle - durum otomatik olarak "Başvuruldu" olarak ayarlanır
    $stmt = $pdo->prepare("INSERT INTO applications (user_id, company_name, position, status, apply_date, notes) VALUES (?, ?, ?, 'Başvuruldu', ?, ?)");
    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['company_name'],
        $_POST['position'],
        $_POST['apply_date'],
        $_POST['notes']
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
    <title>Yeni Başvuru Ekle</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">← Geri Dön</a>
            <span class="text-white">Yeni Başvuru Ekle</span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Yeni Staj Başvurusu</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Şirket Adı *</label>
                                <input type="text" class="form-control" name="company_name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Pozisyon *</label>
                                <input type="text" class="form-control" name="position" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Başvuru Tarihi *</label>
                                <input type="date" class="form-control" name="apply_date" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Notlar</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Başvuru hakkında notlarınız..."></textarea>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="dashboard.php" class="btn btn-secondary">İptal</a>
                                <button type="submit" class="btn btn-success">Başvuru Ekle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>