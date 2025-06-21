<div class="notification-container">
    <?php
    if (!function_exists('get_notifications')) {
        require_once __DIR__ . '/../../helpers/notifications.php';
    }
    $notifications = get_notifications();
    foreach ($notifications as $notification):
        $type = $notification['type'] ?? 'success';
        $alertClass = 'alert-success';
        $icon = '<i class="fas fa-check-circle notification-icon"></i>';

        if ($type === 'warning' || $type === 'aviso') {
            $alertClass = 'alert-warning';
            $icon = '<i class="fas fa-exclamation-triangle notification-icon"></i>';
        } elseif ($type === 'danger' || $type === 'erro' || $type === 'error') {
            $alertClass = 'alert-danger';
            $icon = '<i class="fas fa-times-circle notification-icon"></i>';
        } elseif ($type === 'info' || $type === 'debug') {
            $alertClass = 'alert-info';
            $icon = '<i class="fas fa-info-circle notification-icon"></i>';
        }
    ?>
        <div class="alert <?= $alertClass ?> alert-dismissible fade show notification-float" role="alert"
            data-type="<?= $type ?>" data-created="<?= time() ?>">
            <?= $icon ?>
            <span class="notification-text"><?= htmlspecialchars($notification['message']) ?></span>
            <button type="button" class="btn-close notification-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            <div class="progress-bar-notification"></div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    // JavaScript integrado para compatibilidade
    document.addEventListener('DOMContentLoaded', function() {
        // Sistema de notificações modernas
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

                // Pausar no hover
                notification.addEventListener('mouseenter', () => {
                    this.pauseAutoClose(notification);
                });

                notification.addEventListener('mouseleave', () => {
                    this.resumeAutoClose(notification);
                });

                // Fechar ao clicar
                notification.addEventListener('click', (e) => {
                    if (!e.target.closest('.notification-close')) {
                        this.close(notification);
                    }
                });

                // Remover após animação
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
                    this.container = document.querySelector('.notification-container') || this
                        .createContainer();
                }

                const notification = this.createNotification(message, type);
                this.container.appendChild(notification);

                notification.offsetHeight; // Trigger reflow

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
                notification.setAttribute('data-created', Date.now());

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
                // API global
                window.addNotification = (type, message, duration) => {
                    return this.add(message, type, duration);
                };

                window.showSuccess = (message, duration) => this.add(message, 'success', duration);
                window.showWarning = (message, duration) => this.add(message, 'warning', duration);
                window.showError = (message, duration) => this.add(message, 'error', duration);
                window.showInfo = (message, duration) => this.add(message, 'info', duration);
            }
        }

        // Inicializar sistema
        window.notificationSystem = new NotificationSystem();

        // Fechar todas com ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.notification-float:not(.hide)').forEach(notification => {
                    window.notificationSystem.close(notification);
                });
            }
        });
    });
</script>