<?php
session_start();
include 'includes/config.php';

$success = '';
$error = '';
$email = $_SESSION['reset_email'] ?? null;

if (isset($_POST['submit_email'])) {
    $input_email = mysqli_real_escape_string($conn, $_POST['email']);
    $cek = mysqli_query($conn, "SELECT * FROM user WHERE email = '$input_email'");

    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['reset_email'] = $input_email;
        $email = $input_email;
    } else {
        $error = 'Email tidak ditemukan!';
    }
}

if (isset($_POST['submit_password']) && $email) {
    $new_pass = mysqli_real_escape_string($conn, $_POST['password']);
    $hash = password_hash($new_pass, PASSWORD_DEFAULT);

    $update = mysqli_query($conn, "UPDATE user SET password = '$hash' WHERE email = '$email'");

    if ($update) {
        unset($_SESSION['reset_email']);
        $success = 'Password berhasil diubah. Silakan login.';
    } else {
        $error = 'Gagal mengubah password.';
    }
}
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

:root {
    --primary-dark: #0f172a;
    --primary-slate: #334155;
    --light-slate: #64748b;
    --soft-gray: #f1f5f9;
    --pure-white: #ffffff;
    --success-green: #10b981;
    --danger-red: #ef4444;
    --warning-orange: #f59e0b;
    --info-blue: #3b82f6;
    --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-large: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --border-radius: 16px;
    --border-radius-lg: 24px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    box-sizing: border-box;
}

.modal-content {
    border: none;
    border-radius: var(--border-radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-large);
    backdrop-filter: blur(20px);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Modern Header Design */
.reset-header {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-slate) 100%);
    padding: 3rem 2.5rem 2rem;
    position: relative;
    overflow: hidden;
}

.reset-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 80%, rgba(139, 92, 246, 0.15), transparent 60%),
        radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.1), transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(16, 185, 129, 0.08), transparent 70%);
    animation: backgroundShift 20s ease-in-out infinite;
}

@keyframes backgroundShift {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

.reset-header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.reset-title {
    display: flex;
    align-items: center;
    gap: 1rem;
    color: var(--pure-white);
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.reset-title-icon {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.reset-close {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--pure-white);
    transition: var(--transition);
    backdrop-filter: blur(10px);
    cursor: pointer;
}

.reset-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.05);
}

/* Modern Body Design */
.reset-body {
    padding: 3rem 2.5rem;
    background: linear-gradient(180deg, var(--pure-white) 0%, #fafbfc 100%);
    position: relative;
    min-height: 400px;
}

.reset-body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(148, 163, 184, 0.2), transparent);
}

/* Section Headers */
.section-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 1.5rem 1.75rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: var(--border-radius);
    border: 1px solid #e2e8f0;
    position: relative;
    overflow: hidden;
}

.section-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-dark), var(--primary-slate));
}

.section-title {
    color: var(--primary-slate);
    font-weight: 700;
    font-size: 1.25rem;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.section-subtitle {
    color: var(--light-slate);
    font-size: 0.95rem;
    margin: 0;
    font-weight: 500;
    line-height: 1.5;
}

.section-icon {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-slate));
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--pure-white);
    font-size: 0.9rem;
}

/* Modern Form Styling */
.form-group-modern {
    margin-bottom: 2rem;
    position: relative;
}

.form-label-modern {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: var(--primary-slate);
    margin-bottom: 1rem;
    font-size: 0.95rem;
    letter-spacing: -0.01em;
}

.form-label-icon {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-slate));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 1rem;
}

.form-input-modern {
    width: 100%;
    padding: 1.25rem 1.5rem 1.25rem 3.5rem;
    border: 2px solid #e2e8f0;
    border-radius: var(--border-radius);
    font-size: 1rem;
    font-weight: 500;
    color: var(--primary-slate);
    background: var(--pure-white);
    transition: var(--transition);
    position: relative;
    font-family: inherit;
}

.form-input-modern:focus {
    outline: none;
    border-color: var(--primary-slate);
    box-shadow: 0 0 0 4px rgba(51, 65, 85, 0.1);
    background: var(--pure-white);
}

.form-input-modern::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

.input-icon {
    position: absolute;
    left: 1.25rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--light-slate);
    font-size: 1.1rem;
    pointer-events: none;
    transition: var(--transition);
}

.form-input-modern:focus + .input-icon {
    color: var(--primary-slate);
}

/* Modern Button Design */
.btn-modern {
    width: 100%;
    padding: 1.25rem 2rem;
    border: none;
    border-radius: var(--border-radius);
    font-size: 1rem;
    font-weight: 600;
    text-transform: none;
    letter-spacing: -0.01em;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    font-family: inherit;
    text-decoration: none;
}

.btn-primary-modern {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-slate) 100%);
    color: var(--pure-white);
    box-shadow: var(--shadow-soft);
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
    background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
    color: var(--pure-white);
    text-decoration: none;
}

.btn-primary-modern:active {
    transform: translateY(0);
}

.btn-success-modern {
    background: linear-gradient(135deg, var(--success-green) 0%, #059669 100%);
    color: var(--pure-white);
    box-shadow: var(--shadow-soft);
}

.btn-success-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: var(--pure-white);
    text-decoration: none;
}

/* Modern Alert Design */
.alert-modern {
    padding: 1.5rem 1.75rem;
    border-radius: var(--border-radius);
    font-weight: 500;
    margin-bottom: 2rem;
    border: none;
    position: relative;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.95rem;
    line-height: 1.5;
}

.alert-success-modern {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
    color: #047857;
    border-left: 4px solid var(--success-green);
}

.alert-danger-modern {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
    color: #dc2626;
    border-left: 4px solid var(--danger-red);
}

.alert-info-modern {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
    color: #1d4ed8;
    border-left: 4px solid var(--info-blue);
}

.alert-icon {
    font-size: 1.25rem;
    flex-shrink: 0;
}

/* Progress Steps */
.progress-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 2.5rem;
    gap: 1rem;
}

.step {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition);
}

.step.active {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-slate));
    color: var(--pure-white);
    box-shadow: var(--shadow-soft);
}

.step.inactive {
    background: #e2e8f0;
    color: var(--light-slate);
}

.step-connector {
    width: 60px;
    height: 2px;
    background: #e2e8f0;
    position: relative;
}

.step-connector.active::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background: linear-gradient(90deg, var(--primary-dark), var(--primary-slate));
    animation: progressFill 0.5s ease-out forwards;
}

@keyframes progressFill {
    from { width: 0; }
    to { width: 100%; }
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.6s ease-out;
}

.slide-up {
    animation: slideUp 0.6s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 576px) {
    .reset-header {
        padding: 2rem 1.5rem 1.5rem;
    }
    
    .reset-body {
        padding: 2rem 1.5rem;
    }
    
    .reset-title {
        font-size: 1.5rem;
    }
    
    .form-input-modern {
        padding: 1rem 1.25rem 1rem 3rem;
    }
    
    .btn-modern {
        padding: 1rem 1.5rem;
    }

    .section-header {
        padding: 1.25rem 1.5rem;
    }

    .section-title {
        font-size: 1.1rem;
    }
}
</style>

<div class="modal-content">
    <!-- Header -->
    <div class="reset-header">
        <div class="reset-header-content">
            <h5 class="reset-title">
                <div class="reset-title-icon">
                    <i class="fas fa-key"></i>
                </div>
                Reset Password
            </h5>
            <button type="button" class="reset-close" data-bs-dismiss="modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Body -->
    <div class="reset-body">
        <!-- Progress Steps -->
        <div class="progress-steps">
            <div class="step <?= !$email ? 'active' : 'inactive' ?>">1</div>
            <div class="step-connector <?= $email ? 'active' : '' ?>"></div>
            <div class="step <?= $email && !$success ? 'active' : 'inactive' ?>">2</div>
            <div class="step-connector <?= $success ? 'active' : '' ?>"></div>
            <div class="step <?= $success ? 'active' : 'inactive' ?>">3</div>
        </div>

        <?php if ($success): ?>
            <!-- Success State -->
            <div class="fade-in">
                <div class="alert-modern alert-success-modern">
                    <i class="fas fa-check-circle alert-icon"></i>
                    <div>
                        <strong>Berhasil!</strong><br>
                        <?= $success; ?>
                    </div>
                </div>
                <div class="text-center">
                    <a href="loginuser.php" class="btn-modern btn-success-modern">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk ke Akun Anda
                    </a>
                </div>
            </div>

        <?php else: ?>
            <!-- Error Alert -->
            <?php if ($error): ?>
                <div class="alert-modern alert-danger-modern fade-in">
                    <i class="fas fa-exclamation-triangle alert-icon"></i>
                    <div><?= $error; ?></div>
                </div>
            <?php endif; ?>

            <?php if (!$email): ?>
                <!-- Step 1: Email Input -->
                <div class="slide-up">
                    <div class="section-header">
                        <h6 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            Verifikasi Email
                        </h6>
                        <p class="section-subtitle">
                            Masukkan alamat email yang terdaftar untuk melanjutkan proses reset password
                        </p>
                    </div>

                    <form method="post" action="reset_password.php">
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="form-label-icon fas fa-envelope"></i>
                                Alamat Email
                            </label>
                            <div style="position: relative;">
                                <input type="email" 
                                       name="email" 
                                       class="form-input-modern" 
                                       required 
                                       placeholder="contoh@email.com"
                                       autocomplete="email">
                                <i class="input-icon fas fa-envelope"></i>
                            </div>
                        </div>
                        
                        <button type="submit" name="submit_email" class="btn-modern btn-primary-modern">
                            <i class="fas fa-paper-plane"></i>
                            Verifikasi Email
                        </button>
                    </form>
                </div>

            <?php else: ?>
                <!-- Step 2: Password Reset -->
                <div class="slide-up">
                    <div class="alert-modern alert-info-modern">
                        <i class="fas fa-info-circle alert-icon"></i>
                        <div>
                            <strong>Email Terverifikasi</strong><br>
                            <?= htmlspecialchars($email); ?>
                        </div>
                    </div>

                    <div class="section-header">
                        <h6 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            Buat Password Baru
                        </h6>
                        <p class="section-subtitle">
                            Buat password baru yang aman untuk akun Anda. Pastikan menggunakan kombinasi huruf, angka, dan simbol
                        </p>
                    </div>
                    
                    <form method="post" action="reset_password.php">
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="form-label-icon fas fa-lock"></i>
                                Password Baru
                            </label>
                            <div style="position: relative;">
                                <input type="password" 
                                       name="password" 
                                       class="form-input-modern" 
                                       required 
                                       placeholder="Minimal 6 karakter"
                                       minlength="6"
                                       autocomplete="new-password">
                                <i class="input-icon fas fa-lock"></i>
                            </div>
                        </div>
                        
                        <button type="submit" name="submit_password" class="btn-modern btn-primary-modern">
                            <i class="fas fa-unlock"></i>
                            Reset Password
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>