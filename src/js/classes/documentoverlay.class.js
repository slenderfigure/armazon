class DocOverlay {
    constructor() {
        this.overlay = document.createElement('div');
        this.overlay.className = 'document-overlay';
    }

    showOverlay(content, callback = null) {
        this.overlay.appendChild(content);
    
        document.body.style.overflow = 'hidden';
        document.body.appendChild(this.overlay);
    
        document.addEventListener('keyup', e => {
            if (e.code == 'Escape') { this.hideOverlay(callback); }
        });
    
        document.querySelector('.close-box')
        .addEventListener('click', () => this.hideOverlay(callback));
    }
    
    hideOverlay(callback) {        
        document.body.style.overflow = 'auto';
        this.overlay.style.animation = 'hideModal 0.3s ease forwards';
        setTimeout(() => this.overlay.remove(), 300);

        // if (callback !== null) { callback(); }
    }

    autoHideOverlay(timeout) {
        setTimeout(() => this.hideOverlay(), timeout);
    }
}