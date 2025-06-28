<?php

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title) ?></title>
    <!-- Favicon inline para evitar requisições 404 -->
    <link rel="icon"
        href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=="
        type="image/x-icon">
    <?= $this->section('css'); ?>
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/navbar.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/sidebar-custom.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/navbar-sidebar-integration.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/navbar-dropdown-fix.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/notifications.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/responsive.css">
    <style>
        /* Apenas para evitar o flash de transições no carregamento inicial */
        * {
            -webkit-transition: none !important;
            -moz-transition: none !important;
            -o-transition: none !important;
            transition: none !important;
        }

        body.sidebar-loaded * {
            -webkit-transition: unset !important;
            -moz-transition: unset !important;
            -o-transition: unset !important;
            transition: unset !important;
        }
    </style>
</head>

<body class="dark-mode d-flex flex-column h-100 text-white <?= isset($_SESSION['user']) ? 'has-sidebar' : '' ?>"
    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed;">
    <?php if (isset($_SESSION['user'])): ?>
        <?php $this->insert('partials/sidebar', ['page' => $page]) ?>
        <?php $this->insert('partials/menu', ['page_title' => $current_page, 'page' => $page]) ?>
    <?php endif; ?>
    <?php $this->insert('partials/notifications'); ?>

    <div class="main-wrapper">
        <main class="flex-shrink-0">
            <section>
                <?= $this->section('content') ?>
            </section>
        </main>
    </div>

</body>
<?= $this->section('js'); ?>
<!-- Scripts - Ordem correta para evitar conflitos -->
<!-- 1. jQuery primeiro -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- 2. Popper.js (incluído no bootstrap.bundle.min.js) -->
<!-- 3. Bootstrap JS -->
<script src="/PHP-POO/routes-phpoo/public/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar tooltips do Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                animation: true,
                delay: {
                    "show": 100,
                    "hide": 150
                },
                html: true,
                placement: 'bottom'
            });
        });

        // [REMOVIDO] Controle manual de dropdowns do menu para evitar conflito com Bootstrap 5
        // O Bootstrap 5 já gerencia dropdowns via data-bs-toggle="dropdown" automaticamente.
    });

    document.onkeydown = function($e) {
        if ($e.keyCode == 27) {
            // Fechar dropdowns com ESC
            $('.navbar .dropdown-menu').removeClass('show');

            if (page !== "index.php") {
                history.go(-1)
            } else {
                location.reload();
            }
        }
    }
</script>
<!-- Scripts customizados -->
<script src="/PHP-POO/routes-phpoo/public/js/sidebar.js"></script>
<script>
    // Sistema de Notificações Modernas
    document.addEventListener('DOMContentLoaded', function() {
        class NotificationSystem {
            constructor() {
                this.container = document.querySelector('.notification-container');
                this.defaultDuration = 5000;
                this.init();
            }

            init() {
                this.processExistingNotifications();
                this.setupGlobalAPI();
            }

            processExistingNotifications() {
                const notifications = document.querySelectorAll('.notification-float');
                notifications.forEach((notification, index) => {
                    this.setupNotificationEvents(notification);
                    this.scheduleAutoClose(notification, this.defaultDuration + (index * 100));
                });
            }

            setupNotificationEvents(notification) {
                const closeBtn = notification.querySelector('.notification-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        this.close(notification);
                    });
                }

                notification.addEventListener('mouseenter', () => {
                    this.pauseAutoClose(notification);
                });

                notification.addEventListener('mouseleave', () => {
                    this.resumeAutoClose(notification);
                });

                notification.addEventListener('click', (e) => {
                    if (!e.target.closest('.notification-close')) {
                        this.close(notification);
                    }
                });

                notification.addEventListener('transitionend', (e) => {
                    if (e.target === notification && notification.classList.contains('hide')) {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }
                });
            }

            scheduleAutoClose(notification, duration) {
                const timeoutId = setTimeout(() => {
                    if (notification.parentNode) {
                        this.close(notification);
                    }
                }, duration);
                notification.setAttribute('data-timeout-id', timeoutId);
            }

            pauseAutoClose(notification) {
                const timeoutId = notification.getAttribute('data-timeout-id');
                if (timeoutId) {
                    clearTimeout(timeoutId);
                    notification.removeAttribute('data-timeout-id');
                }
            }

            resumeAutoClose(notification, remainingTime = 2000) {
                this.scheduleAutoClose(notification, remainingTime);
            }

            close(notification) {
                if (notification.classList.contains('hide')) return;

                notification.classList.remove('show');
                notification.classList.add('hide');

                const timeoutId = notification.getAttribute('data-timeout-id');
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
            }

            add(message, type = 'success', duration = null) {
                if (!this.container) {
                    this.container = this.createContainer();
                }

                const notification = this.createNotification(message, type);
                this.container.appendChild(notification);

                notification.offsetHeight;

                this.setupNotificationEvents(notification);
                this.scheduleAutoClose(notification, duration || this.defaultDuration);

                return notification;
            }

            createContainer() {
                const container = document.createElement('div');
                container.className = 'notification-container';
                document.body.appendChild(container);
                return container;
            }

            createNotification(message, type) {
                const icons = {
                    success: 'fas fa-check-circle',
                    warning: 'fas fa-exclamation-triangle',
                    danger: 'fas fa-times-circle',
                    error: 'fas fa-times-circle',
                    info: 'fas fa-info-circle'
                };

                const alertClass = `alert-${type === 'error' ? 'danger' : type}`;
                const iconClass = icons[type] || icons.success;

                const notification = document.createElement('div');
                notification.className = `alert ${alertClass} alert-dismissible fade show notification-float`;
                notification.setAttribute('role', 'alert');
                notification.setAttribute('data-type', type);

                notification.innerHTML = `
                <i class="${iconClass} notification-icon"></i>
                <span class="notification-text">${this.escapeHtml(message)}</span>
                <button type="button" class="btn-close notification-close" aria-label="Fechar"></button>
                <div class="progress-bar-notification"></div>
            `;

                return notification;
            }

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            setupGlobalAPI() {
                window.addNotification = (type, message, duration) => {
                    return this.add(message, type, duration);
                };

                window.showSuccess = (message, duration) => this.add(message, 'success', duration);
                window.showWarning = (message, duration) => this.add(message, 'warning', duration);
                window.showError = (message, duration) => this.add(message, 'error', duration);
                window.showInfo = (message, duration) => this.add(message, 'info', duration);
            }
        }

        window.notificationSystem = new NotificationSystem();

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.notification-float:not(.hide)').forEach(notification => {
                    window.notificationSystem.close(notification);
                });
            }
        });
    });
</script>
<!-- Debug apenas em desenvolvimento -->
<script src="/PHP-POO/routes-phpoo/public/js/sidebar-debug.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function handleNavbarCollapse() {
            var navbarCollapse = document.querySelector('.navbar-collapse');
            var navbarToggler = document.querySelector('.navbar-toggler');
            if (!navbarCollapse) return;

            if (window.innerWidth >= 992) {
                // Desktop: sempre expandido
                navbarCollapse.classList.add('show');
                if (navbarToggler) navbarToggler.setAttribute('aria-expanded', 'true');
            } else {
                // Mobile: sempre colapsado
                navbarCollapse.classList.remove('show');
                if (navbarToggler) navbarToggler.setAttribute('aria-expanded', 'false');
            }
        }

        // Executa ao carregar e ao redimensionar
        handleNavbarCollapse();
        window.addEventListener('resize', handleNavbarCollapse);
    });
</script>

<script src="/PHP-POO/routes-phpoo/public/js/navbar.js"></script>

</html>