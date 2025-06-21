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
        } elseif ($type === 'danger' || $type === 'erro') {
            $alertClass = 'alert-danger';
            $icon = '<i class="fas fa-times-circle notification-icon"></i>';
        } elseif ($type === 'info' || $type === 'debug') {
            $alertClass = 'alert-info';
            $icon = '<i class="fas fa-info-circle notification-icon"></i>';
        }
    ?>
        <div class="alert <?= $alertClass ?> alert-dismissible fade show notification-float" role="alert">
            <?= $icon ?>
            <?= htmlspecialchars($notification['message']) ?>
            <button type="button" class="btn-close notification-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            <div class="progress-bar-notification"></div>
        </div>
    <?php endforeach; ?>
</div>