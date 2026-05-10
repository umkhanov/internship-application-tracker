<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staj Başvuru Takip Sistemi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Staj Başvuru Takip Sistemi</h3>
                    </div>
                    <div class="card-body">
                        <!-- Hata mesajları -->
                        <?php if(isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <?php
                                switch($_GET['error']) {
                                    case '1':
                                        echo 'Kullanıcı adı veya şifre hatalı!';
                                        break;
                                    case '2':
                                        echo 'Bu kullanıcı adı zaten kullanılıyor!';
                                        break;
                                    case '3':
                                        echo 'E-posta adresi zaten kayıtlı!';
                                        break;
                                    case '4':
                                        echo 'Lütfen tüm alanları doldurun!';
                                        break;
                                    case '5':
                                        echo 'Geçerli bir e-posta adresi girin!';
                                        break;
                                    case '6':
                                        echo 'Şifre en az 6 karakter olmalıdır!';
                                        break;
                                    default:
                                        echo 'Bir hata oluştu!';
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <!-- Başarı mesajları -->
                        <?php if(isset($_GET['success'])): ?>
                            <div class="alert alert-success">
                                <?php
                                switch($_GET['success']) {
                                    case '1':
                                        echo 'Kayıt başarılı! Şimdi giriş yapabilirsiniz.';
                                        break;
                                    case '2':
                                        echo 'Hesabınız başarıyla silindi. Sistemimizi kullandığınız için teşekkürler.';
                                        break;
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <!-- Giriş Formu -->
                        <div id="loginForm">
                            <h5>Giriş Yap</h5>
                            <form action="login.php" method="POST" onsubmit="return validateLogin()">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="username" id="loginUsername" placeholder="Kullanıcı Adı" required>
                                    <div class="invalid-feedback" id="loginUsernameError"></div>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password" id="loginPassword" placeholder="Şifre" required>
                                    <div class="invalid-feedback" id="loginPasswordError"></div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                            </form>
                            <hr>
                            <button class="btn btn-secondary w-100" onclick="showRegister()">Kayıt Ol</button>
                        </div>

                        <!-- Kayıt Formu -->
                        <div id="registerForm" style="display:none;">
                            <h5>Kayıt Ol</h5>
                            <form action="register.php" method="POST" onsubmit="return validateRegister()">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="username" id="regUsername" placeholder="Kullanıcı Adı" required>
                                    <div class="invalid-feedback" id="regUsernameError"></div>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" id="regEmail" placeholder="E-posta" required>
                                    <div class="invalid-feedback" id="regEmailError"></div>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password" id="regPassword" placeholder="Şifre (en az 6 karakter)" required>
                                    <div class="invalid-feedback" id="regPasswordError"></div>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password_confirm" id="regPasswordConfirm" placeholder="Şifre Tekrar" required>
                                    <div class="invalid-feedback" id="regPasswordConfirmError"></div>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Kayıt Ol</button>
                            </form>
                            <hr>
                            <button class="btn btn-secondary w-100" onclick="showLogin()">Giriş Yap</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showRegister() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
            clearErrors();
        }
        
        function showLogin() {
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
            clearErrors();
        }

        function clearErrors() {
            const errorElements = document.querySelectorAll('.invalid-feedback');
            const inputElements = document.querySelectorAll('.form-control');
            
            errorElements.forEach(el => {
                el.textContent = '';
                el.style.display = 'none';
            });
            
            inputElements.forEach(el => {
                el.classList.remove('is-invalid');
            });
        }

        function showError(inputId, errorId, message) {
            const input = document.getElementById(inputId);
            const error = document.getElementById(errorId);
            
            input.classList.add('is-invalid');
            error.textContent = message;
            error.style.display = 'block';
        }

        function validateLogin() {
            clearErrors();
            let isValid = true;

            const username = document.getElementById('loginUsername').value.trim();
            const password = document.getElementById('loginPassword').value;

            if (username === '') {
                showError('loginUsername', 'loginUsernameError', 'Kullanıcı adı gereklidir.');
                isValid = false;
            } else if (username.length < 3) {
                showError('loginUsername', 'loginUsernameError', 'Kullanıcı adı en az 3 karakter olmalıdır.');
                isValid = false;
            }

            if (password === '') {
                showError('loginPassword', 'loginPasswordError', 'Şifre gereklidir.');
                isValid = false;
            }

            return isValid;
        }

        function validateRegister() {
            clearErrors();
            let isValid = true;

            const username = document.getElementById('regUsername').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            const password = document.getElementById('regPassword').value;
            const passwordConfirm = document.getElementById('regPasswordConfirm').value;

            // Kullanıcı adı kontrolü
            if (username === '') {
                showError('regUsername', 'regUsernameError', 'Kullanıcı adı gereklidir.');
                isValid = false;
            } else if (username.length < 3) {
                showError('regUsername', 'regUsernameError', 'Kullanıcı adı en az 3 karakter olmalıdır.');
                isValid = false;
            } else if (username.length > 20) {
                showError('regUsername', 'regUsernameError', 'Kullanıcı adı en fazla 20 karakter olabilir.');
                isValid = false;
            } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
                showError('regUsername', 'regUsernameError', 'Kullanıcı adı sadece harfler, rakamlar ve alt çizgi içerebilir.');
                isValid = false;
            }

            // E-posta kontrolü
            if (email === '') {
                showError('regEmail', 'regEmailError', 'E-posta adresi gereklidir.');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showError('regEmail', 'regEmailError', 'Geçerli bir e-posta adresi girin.');
                isValid = false;
            }

            // Şifre kontrolü
            if (password === '') {
                showError('regPassword', 'regPasswordError', 'Şifre gereklidir.');
                isValid = false;
            } else if (password.length < 6) {
                showError('regPassword', 'regPasswordError', 'Şifre en az 6 karakter olmalıdır.');
                isValid = false;
            } else if (password.length > 50) {
                showError('regPassword', 'regPasswordError', 'Şifre en fazla 50 karakter olabilir.');
                isValid = false;
            }

            // Şifre tekrar kontrolü
            if (passwordConfirm === '') {
                showError('regPasswordConfirm', 'regPasswordConfirmError', 'Şifre tekrarı gereklidir.');
                isValid = false;
            } else if (password !== passwordConfirm) {
                showError('regPasswordConfirm', 'regPasswordConfirmError', 'Şifreler eşleşmiyor.');
                isValid = false;
            }

            return isValid;
        }

        // URL'den hash parametresini temizle
        if (window.location.hash) {
            history.replaceState(null, null, window.location.pathname + window.location.search);
        }
    </script>
</body>
</html>