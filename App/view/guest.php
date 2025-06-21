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
        // Sistema de Notificações Moderno Integrado
        class NotificationSystem {
            constructor() {
                this.container = null;
                this.notifications = new Map();
            }

            createContainer() {
                const container = document.createElement('div');
                container.className = 'notification-container';
                document.body.appendChild(container);
                return container;
            }

            add(message, type = 'success', duration = null) {
                if (!this.container) {
                    this.container = document.querySelector('.notification-container') || this.createContainer();
                }

                const id = 'notification-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                const notification = this.createNotification(message, type, id);

                this.container.appendChild(notification);
                this.notifications.set(id, notification);

                // Animação de entrada
                requestAnimationFrame(() => {
                    notification.style.transform = 'translateX(0)';
                    notification.style.opacity = '1';
                });

                // Auto-close (configurável por tipo)
                const autoCloseTime = duration || this.getDefaultDuration(type);
                if (autoCloseTime > 0) {
                    this.scheduleRemoval(id, autoCloseTime);
                }

                return id;
            }

            createNotification(message, type, id) {
                const notification = document.createElement('div');
                const icons = {
                    success: 'fas fa-check-circle',
                    error: 'fas fa-exclamation-circle',
                    warning: 'fas fa-exclamation-triangle',
                    info: 'fas fa-info-circle'
                };

                notification.className = `notification-modern notification-${type}`;
                notification.id = id;
                notification.setAttribute('data-type', type);
                notification.setAttribute('data-created', Date.now());

                notification.innerHTML = `
                <div class="notification-content">
                    <i class="${icons[type] || icons.info}"></i>
                    <span class="notification-message">${message}</span>
                    <button class="notification-close" onclick="window.notifications.remove('${id}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="notification-progress"></div>
            `;

                // Eventos
                notification.addEventListener('mouseenter', () => this.pauseAutoClose(id));
                notification.addEventListener('mouseleave', () => this.resumeAutoClose(id));
                notification.addEventListener('click', (e) => {
                    if (!e.target.closest('.notification-close')) {
                        this.remove(id);
                    }
                });

                return notification;
            }

            getDefaultDuration(type) {
                const durations = {
                    error: 8000,
                    warning: 6000,
                    success: 4000,
                    info: 5000
                };
                return durations[type] || 5000;
            }

            scheduleRemoval(id, duration) {
                const notification = this.notifications.get(id);
                if (!notification) return;

                const progressBar = notification.querySelector('.notification-progress');
                if (progressBar) {
                    progressBar.style.animationDuration = `${duration}ms`;
                    progressBar.classList.add('notification-progress-active');
                }

                const timeoutId = setTimeout(() => this.remove(id), duration);
                notification.dataset.timeoutId = timeoutId;
            }

            pauseAutoClose(id) {
                const notification = this.notifications.get(id);
                if (!notification) return;

                const timeoutId = notification.dataset.timeoutId;
                if (timeoutId) {
                    clearTimeout(timeoutId);
                    const progressBar = notification.querySelector('.notification-progress');
                    if (progressBar) {
                        progressBar.style.animationPlayState = 'paused';
                    }
                }
            }

            resumeAutoClose(id) {
                const notification = this.notifications.get(id);
                if (!notification) return;

                const progressBar = notification.querySelector('.notification-progress');
                if (progressBar) {
                    progressBar.style.animationPlayState = 'running';
                }
            }

            remove(id) {
                const notification = this.notifications.get(id);
                if (!notification) return;

                // Limpar timeout se existir
                const timeoutId = notification.dataset.timeoutId;
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }

                // Animação de saída
                notification.style.transform = 'translateX(100%)';
                notification.style.opacity = '0';

                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                    this.notifications.delete(id);
                }, 300);
            }

            removeAll() {
                this.notifications.forEach((notification, id) => {
                    this.remove(id);
                });
            }

            // Atalhos globais
            showSuccess(message, duration = null) {
                return this.add(message, 'success', duration);
            }

            showError(message, duration = null) {
                return this.add(message, 'error', duration);
            }

            showWarning(message, duration = null) {
                return this.add(message, 'warning', duration);
            }

            showInfo(message, duration = null) {
                return this.add(message, 'info', duration);
            }
        }

        // Instância global
        window.notifications = new NotificationSystem();

        // Atalhos globais para compatibilidade
        window.showSuccess = (message, duration) => window.notifications.showSuccess(message, duration);
        window.showError = (message, duration) => window.notifications.showError(message, duration);
        window.showWarning = (message, duration) => window.notifications.showWarning(message, duration);
        window.showInfo = (message, duration) => window.notifications.showInfo(message, duration);
        window.addNotification = (type, message, duration) => window.notifications.add(message, type, duration);

        // Fechar todas as notificações com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.notifications.removeAll();
            }
        });

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