<?php
require_once '../config/database.php';
checkLogin();

// Kullanıcının tüm staj başvurularını getir
$stmt = $pdo->prepare("SELECT * FROM applications WHERE user_id = ? ORDER BY apply_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$applications = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staj Başvurularım</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">Staj Takip Sistemi</span>
            <div>
                <span class="text-white me-3">Hoş geldin, <?= $_SESSION['username'] ?></span>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        Hesap
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteAccount()">Hesabı Sil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Çıkış</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Hata mesajları -->
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php
                switch($_GET['error']) {
                    case '1':
                        echo 'Hesap silinirken bir hata oluştu. Lütfen tekrar deneyin.';
                        break;
                    default:
                        echo 'Bir hata oluştu!';
                }
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Staj Başvurularım</h2>
            <a href="add.php" class="btn btn-success">Yeni Başvuru Ekle</a>
        </div>

        <?php if (empty($applications)): ?>
            <div class="alert alert-info">
                Henüz hiç başvuru yapmadınız. <a href="add.php">İlk başvurunuzu ekleyin!</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Şirket</th>
                            <th>Pozisyon</th>
                            <th>Durum</th>
                            <th>Başvuru Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?= htmlspecialchars($app['company_name']) ?></td>
                            <td><?= htmlspecialchars($app['position']) ?></td>
                            <td>
                                <span class="badge bg-<?= 
                                    $app['status'] == 'Kabul' ? 'success' : 
                                    ($app['status'] == 'Red' ? 'danger' : 
                                    ($app['status'] == 'Görüşme' ? 'warning' : 'secondary')) 
                                ?>">
                                    <?= $app['status'] ?>
                                </span>
                            </td>
                            <td><?= date('d.m.Y', strtotime($app['apply_date'])) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $app['id'] ?>" class="btn btn-sm btn-outline-primary">Düzenle</a>
                                <a href="delete.php?id=<?= $app['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Bu başvuruyu silmek istediğinizden emin misiniz?')">Sil</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function deleteAccount() {
            if (confirm('UYARI: Hesabınızı silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz ve tüm başvuru verileriniz silinecektir!')) {
                if (confirm('Son onay: Hesabınızı kalıcı olarak silmek istediğinizden emin misiniz?')) {
                    window.location.href = 'delete_account.php';
                }
            }
        }
    </script>
</body>
</html>