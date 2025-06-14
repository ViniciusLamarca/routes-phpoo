// Remove o elemento do DOM após a transição de opacidade
window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.notification-float').forEach(function(alert) {
        alert.addEventListener('transitionend', function() {
            if (alert.classList.contains('hide')) {
                alert.parentNode.removeChild(alert);
            }
        });
    });

    setTimeout(function() {
        let alerts = document.querySelectorAll('.notification-float');
        alerts.forEach(function(alert) {
            alert.classList.remove('show');
            alert.classList.add('hide');
        });
    }, 4000); // 4 segundos
}); 