<div style="position: fixed; top: 100px; right: 20px; z-index: 9999; min-width: 320px;">
    <?php
    if (!function_exists('get_notifications')) {
        require_once __DIR__ . '/../../helpers/notifications.php';
    }
    $notifications = get_notifications();
    foreach ($notifications as $notification): ?>
        <div class="alert alert-success alert-dismissible fade show notification-float" role="alert" style="box-shadow: 0 4px 16px rgba(0,0,0,0.18); border-radius: 12px; font-size: 1.1rem; background: rgba(72, 232, 151, 0.92); color: #155724; border: none; animation: slideDown 0.5s; position: relative; overflow: hidden;">
            <?= htmlspecialchars($notification['message']) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar" style="color: #155724; opacity: 0.8;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="progress-bar-notification"></div>
        </div>
    <?php endforeach; ?>
</div>
<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .notification-float {
        opacity: 0.9;
        transition: opacity 0.5s;
    }

    .notification-float.hide {
        opacity: 0;
        pointer-events: none;
    }

    .progress-bar-notification {
        position: absolute;
        left: 0;
        bottom: 0;
        height: 4px;
        width: 100%;
        background: rgba(21, 87, 36, 0.15);
        overflow: hidden;
    }

    .progress-bar-notification::after {
        content: '';
        display: block;
        height: 100%;
        width: 100%;
        background: #155724;
        animation: progressBarAnim 4s linear forwards;
    }

    @keyframes progressBarAnim {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }
</style>
<script>
    // Remove o elemento do DOM após a transição de opacidade
    document.querySelectorAll('.notification-float').forEach(function(alert) {
        alert.addEventListener('transitionend', function() {
            if (alert.classList.contains('hide')) {
                alert.parentNode.removeChild(alert);
            }
        });
    });
</script>