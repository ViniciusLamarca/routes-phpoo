<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title) ?></title>
    <?= $this->section('css'); ?>
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/notifications.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/sidebar-custom.css">
    <style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .guest-container {
        width: 100%;
        max-width: 500px;
        padding: 2rem;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }

    .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 2rem 2rem 1rem;
    }

    .card-body {
        padding: 2rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 15px rgba(102, 126, 234, 0.2);
    }

    .form-control::placeholder {
        color: rgba(176, 176, 176, 0.7) !important;
        opacity: 1;
    }

    .brand-logo {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .guest-links {
        text-align: center;
        margin-top: 2rem;
    }

    .guest-links a {
        color: #667eea;
        text-decoration: none;
        margin: 0 1rem;
        transition: color 0.3s ease;
    }

    .guest-links a:hover {
        color: #764ba2;
    }

    body.dark-mode {
        background: linear-gradient(135deg, rgb(90, 113, 214) 0%, rgb(111, 70, 151) 100%) !important;
        color: #e0e0e0 !important;
    }

    .dark-mode .guest-container {
        background: none;
    }

    .dark-mode .card,
    .dark-mode .card-header,
    .dark-mode .card-body {
        background: rgba(30, 32, 40, 0.98) !important;
        color: #e0e0e0 !important;
        border-color: #23272f !important;
    }

    .dark-mode .card-header {
        border-bottom: 1px solid #23272f !important;
    }

    .dark-mode .form-control {
        background: #23272f !important;
        color: #e0e0e0 !important;
        border: 1px solid #3a3f4b !important;
    }

    .dark-mode .form-control:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 8px #667eea44 !important;
    }

    .dark-mode .form-control::placeholder {
        color: rgba(224, 224, 224, 0.6) !important;
        opacity: 1;
    }

    .dark-mode .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: #fff !important;
        border: none !important;
    }

    .dark-mode .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fdc 0%, #5a3e7a 100%) !important;
    }

    .dark-mode .brand-logo {
        color: #667eea !important;
    }

    .dark-mode .guest-links a {
        color: #a7bfff !important;
    }

    .dark-mode .guest-links a:hover {
        color: #764ba2 !important;
    }
    </style>
</head>

<body class="dark-mode">
    <?php $this->insert('partials/notifications'); ?>

    <div class="guest-container">
        <div class="text-center mb-4">
            <i class="fas fa-leaf brand-logo"></i>
            <h2 class="text-white mb-0">Meu Sistema</h2>
        </div>

        <?= $this->section('content') ?>

        <div class="guest-links">
            <?php if ($page !== 'login.php'): ?>
            <a href="/PHP-POO/routes-phpoo/public/login.php">
                <i class="fas fa-sign-in-alt"></i> Fazer Login
            </a>
            <?php endif; ?>
        </div>
    </div>

    <?= $this->section('js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="/PHP-POO/routes-phpoo/public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="/PHP-POO/routes-phpoo/public/js/notifications.js"></script>

    <script>
    $(document).ready(function() {
        // Inicialize todos os tooltips na página
        $('[data-toggle="tooltip"]').tooltip({
            animation: true,
            delay: {
                "show": 100,
                "hide": 150
            },
            html: true,
            placement: 'bottom'
        });
    });
    </script>
</body>

</html>