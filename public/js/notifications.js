/**
 * Sistema de Notificações Modernas
 * Gerencia notificações toast com animações avançadas e UX melhorada
 */

class NotificationSystem {
  constructor() {
    this.container = null;
    this.notifications = new Map();
    this.defaultDuration = 5000;
    this.init();
  }

  init() {
    this.createContainer();
    this.setupEventListeners();
    this.processExistingNotifications();
  }

  createContainer() {
    if (!document.querySelector(".notification-container")) {
      this.container = document.createElement("div");
      this.container.className = "notification-container";
      document.body.appendChild(this.container);
    } else {
      this.container = document.querySelector(".notification-container");
    }
  }

  setupEventListeners() {
    // Fechar notificações ao pressionar ESC
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        this.clearAll();
      }
    });

    // Pausar auto-close no hover
    this.container.addEventListener(
      "mouseenter",
      (e) => {
        if (e.target.classList.contains("notification-float")) {
          this.pauseAutoClose(e.target);
        }
      },
      true
    );

    this.container.addEventListener(
      "mouseleave",
      (e) => {
        if (e.target.classList.contains("notification-float")) {
          this.resumeAutoClose(e.target);
        }
      },
      true
    );
  }

  processExistingNotifications() {
    const existingNotifications = document.querySelectorAll(
      ".notification-float"
    );
    existingNotifications.forEach((notification, index) => {
      this.setupNotificationEvents(notification);
      this.scheduleAutoClose(notification, this.defaultDuration + index * 100);
    });
  }

  add(message, type = "success", duration = null) {
    const notification = this.createNotification(message, type);
    this.container.appendChild(notification);

    // Trigger reflow para animação
    notification.offsetHeight;

    this.setupNotificationEvents(notification);
    this.scheduleAutoClose(notification, duration || this.defaultDuration);

    return notification;
  }

  createNotification(message, type) {
    const id =
      "notification-" + Date.now() + Math.random().toString(36).substr(2, 9);

    const icons = {
      success: "fas fa-check-circle",
      warning: "fas fa-exclamation-triangle",
      danger: "fas fa-times-circle",
      error: "fas fa-times-circle",
      info: "fas fa-info-circle",
    };

    const alertClass = `alert-${type === "error" ? "danger" : type}`;
    const iconClass = icons[type] || icons.success;

    const notification = document.createElement("div");
    notification.id = id;
    notification.className = `alert ${alertClass} alert-dismissible fade show notification-float`;
    notification.setAttribute("role", "alert");
    notification.setAttribute("data-type", type);

    notification.innerHTML = `
            <i class="${iconClass} notification-icon"></i>
            <span class="notification-text">${this.escapeHtml(message)}</span>
            <button type="button" class="btn-close notification-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            <div class="progress-bar-notification"></div>
        `;

    this.notifications.set(id, {
      element: notification,
      type: type,
      message: message,
      createdAt: Date.now(),
    });

    return notification;
  }

  setupNotificationEvents(notification) {
    const closeBtn = notification.querySelector(".notification-close");
    if (closeBtn) {
      closeBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.close(notification);
      });
    }

    // Fechar ao clicar na notificação (opcional)
    notification.addEventListener("click", (e) => {
      if (!e.target.closest(".notification-close")) {
        this.close(notification);
      }
    });

    // Transição para remoção
    notification.addEventListener("transitionend", (e) => {
      if (
        e.target === notification &&
        notification.classList.contains("hide")
      ) {
        this.remove(notification);
      }
    });
  }

  scheduleAutoClose(notification, duration) {
    const timeoutId = setTimeout(() => {
      if (notification.parentNode) {
        this.close(notification);
      }
    }, duration);

    notification.setAttribute("data-timeout-id", timeoutId);
  }

  pauseAutoClose(notification) {
    const timeoutId = notification.getAttribute("data-timeout-id");
    if (timeoutId) {
      clearTimeout(timeoutId);
      notification.removeAttribute("data-timeout-id");
    }
  }

  resumeAutoClose(notification, remainingTime = 2000) {
    this.scheduleAutoClose(notification, remainingTime);
  }

  close(notification) {
    if (notification.classList.contains("hide")) return;

    notification.classList.remove("show");
    notification.classList.add("hide");

    // Clear timeout se existir
    const timeoutId = notification.getAttribute("data-timeout-id");
    if (timeoutId) {
      clearTimeout(timeoutId);
    }
  }

  remove(notification) {
    const id = notification.id;
    if (this.notifications.has(id)) {
      this.notifications.delete(id);
    }

    if (notification.parentNode) {
      notification.parentNode.removeChild(notification);
    }
  }

  clearAll() {
    const notifications = this.container.querySelectorAll(
      ".notification-float:not(.hide)"
    );
    notifications.forEach((notification) => {
      this.close(notification);
    });
  }

  escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
  }

  // Métodos de conveniência
  success(message, duration) {
    return this.add(message, "success", duration);
  }

  warning(message, duration) {
    return this.add(message, "warning", duration);
  }

  error(message, duration) {
    return this.add(message, "danger", duration);
  }

  info(message, duration) {
    return this.add(message, "info", duration);
  }
}

// Inicializar sistema
let notificationSystem;

document.addEventListener("DOMContentLoaded", function () {
  notificationSystem = new NotificationSystem();
});

// API global para compatibilidade
window.addNotification = function (type, message, duration) {
  if (notificationSystem) {
    return notificationSystem.add(message, type, duration);
  }
};

// Aliases para conveniência
window.showSuccess = function (message, duration) {
  return window.addNotification("success", message, duration);
};

window.showWarning = function (message, duration) {
  return window.addNotification("warning", message, duration);
};

window.showError = function (message, duration) {
  return window.addNotification("error", message, duration);
};

window.showInfo = function (message, duration) {
  return window.addNotification("info", message, duration);
};
