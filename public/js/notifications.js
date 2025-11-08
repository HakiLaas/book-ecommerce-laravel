/**
 * macOS-style Notification System
 * Provides beautiful, native-feeling notifications
 */

class NotificationSystem {
    constructor() {
        this.container = null;
        this.notifications = new Map();
        this.init();
    }

    init() {
        // Create notification container
        this.container = document.createElement('div');
        this.container.className = 'notification-container';
        document.body.appendChild(this.container);

        // Load CSS if not already loaded
        if (!document.querySelector('link[href*="notifications.css"]')) {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = '/css/notifications.css';
            document.head.appendChild(link);
        }
    }

    /**
     * Show a notification
     * @param {Object} options - Notification options
     * @param {string} options.title - Notification title
     * @param {string} options.message - Notification message
     * @param {string} options.type - Notification type (success, error, warning, info)
     * @param {number} options.duration - Auto-hide duration in ms (default: 4000)
     * @param {boolean} options.closable - Whether notification can be closed manually
     * @param {Function} options.onClick - Click handler
     * @param {Function} options.onClose - Close handler
     */
    show({
        title = 'Notification',
        message = '',
        type = 'info',
        duration = 4000,
        closable = true,
        onClick = null,
        onClose = null
    } = {}) {
        const id = this.generateId();
        const notification = this.createNotification({
            id,
            title,
            message,
            type,
            duration,
            closable,
            onClick,
            onClose
        });

        this.container.appendChild(notification);
        this.notifications.set(id, notification);

        // Trigger show animation
        requestAnimationFrame(() => {
            notification.classList.add('show');
        });

        // Auto-hide if duration is set
        if (duration > 0) {
            this.scheduleAutoHide(id, duration);
        }

        return id;
    }

    createNotification({ id, title, message, type, closable, onClick, onClose }) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.dataset.id = id;

        const icon = this.getIcon(type);
        
        notification.innerHTML = `
            <div class="notification-header">
                <h4 class="notification-title">
                    <span class="notification-icon">${icon}</span>
                    ${title}
                </h4>
                ${closable ? '<button class="notification-close" aria-label="Close">&times;</button>' : ''}
            </div>
            <p class="notification-message">${message}</p>
            <div class="notification-progress ${type}"></div>
        `;

        // Add click handler
        if (onClick) {
            notification.style.cursor = 'pointer';
            notification.addEventListener('click', onClick);
        }

        // Add close handler
        const closeBtn = notification.querySelector('.notification-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.hide(id);
                if (onClose) onClose();
            });
        }

        return notification;
    }

    getIcon(type) {
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'i'
        };
        return icons[type] || icons.info;
    }

    scheduleAutoHide(id, duration) {
        const notification = this.notifications.get(id);
        if (!notification) return;

        const progressBar = notification.querySelector('.notification-progress');
        if (progressBar) {
            progressBar.style.setProperty('--duration', `${duration}ms`);
            progressBar.classList.add('animate');
        }

        setTimeout(() => {
            this.hide(id);
        }, duration);
    }

    hide(id) {
        const notification = this.notifications.get(id);
        if (!notification) return;

        notification.classList.add('hide');
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
            this.notifications.delete(id);
        }, 400); // Match CSS transition duration
    }

    hideAll() {
        this.notifications.forEach((notification, id) => {
            this.hide(id);
        });
    }

    generateId() {
        return 'notification_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }
}

// Global notification functions for easy use
window.notifications = new NotificationSystem();

// Convenience functions
window.showNotification = (message, type = 'info', options = {}) => {
    return window.notifications.show({
        message,
        type,
        ...options
    });
};

window.showSuccess = (message, options = {}) => {
    return window.notifications.show({
        title: 'Berhasil',
        message,
        type: 'success',
        ...options
    });
};

window.showError = (message, options = {}) => {
    return window.notifications.show({
        title: 'Error',
        message,
        type: 'error',
        duration: 6000, // Longer duration for errors
        ...options
    });
};

window.showWarning = (message, options = {}) => {
    return window.notifications.show({
        title: 'Peringatan',
        message,
        type: 'warning',
        ...options
    });
};

window.showInfo = (message, options = {}) => {
    return window.notifications.show({
        title: 'Informasi',
        message,
        type: 'info',
        ...options
    });
};

// Book store specific notifications
window.showWelcomeNotification = (userName) => {
    return window.notifications.show({
        title: 'Selamat Datang!',
        message: `Halo ${userName}, selamat datang di Econic Book Store!`,
        type: 'success',
        duration: 5000
    });
};

window.showAddedToFavorites = (bookTitle) => {
    return window.notifications.show({
        title: 'Ditambahkan ke Favorit',
        message: `"${bookTitle}" telah ditambahkan ke daftar favorit Anda`,
        type: 'success',
        duration: 3000
    });
};

window.showRemovedFromFavorites = (bookTitle) => {
    return window.notifications.show({
        title: 'Dihapus dari Favorit',
        message: `"${bookTitle}" telah dihapus dari daftar favorit Anda`,
        type: 'info',
        duration: 3000
    });
};

window.showAddedToCart = (bookTitle) => {
    return window.notifications.show({
        title: 'Ditambahkan ke Keranjang',
        message: `"${bookTitle}" telah ditambahkan ke keranjang belanja Anda`,
        type: 'success',
        duration: 3000
    });
};

window.showPurchaseSuccess = (totalAmount) => {
    return window.notifications.show({
        title: 'Pembelian Berhasil!',
        message: `Pembelian senilai Rp ${totalAmount.toLocaleString('id-ID')} telah berhasil`,
        type: 'success',
        duration: 5000
    });
};

window.showLoginSuccess = (userName) => {
    return window.notifications.show({
        title: 'Login Berhasil',
        message: `Selamat datang kembali, ${userName}!`,
        type: 'success',
        duration: 4000
    });
};

window.showLogoutSuccess = () => {
    return window.notifications.show({
        title: 'Logout Berhasil',
        message: 'Anda telah berhasil logout',
        type: 'info',
        duration: 3000
    });
};

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = NotificationSystem;
}
