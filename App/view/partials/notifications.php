<div class="notification-container">
    <?php
    if (!function_exists('get_notifications')) {
        require_once __DIR__ . '/../../helpers/notifications.php';
    }
    $notifications = get_notifications();
    foreach ($notifications as $notification):
        $type = $notification['type'] ?? 'success';
        $alertClass = 'alert-success';
        if ($type === 'warning' || $type === 'aviso') {
            $alertClass = 'alert-warning';
        } elseif ($type === 'danger' || $type === 'erro') {
            $alertClass = 'alert-danger';
        } elseif ($type === 'info' || $type === 'debug') {
            $alertClass = 'alert-info';
        }
    ?>
        <div class="alert <?= $alertClass ?> alert-dismissible fade show notification-float" role="alert">
            <?= htmlspecialchars($notification['message']) ?>
            <button type="button" class="btn-close notification-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            <div class="progress-bar-notification"></div>
        </div>
    <?php endforeach; ?>
</div>