// PWA Installation Handler
let deferredPrompt;
let installButton;

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', () => {
    initPWA();
});

function initPWA() {
    // Register Service Worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then((registration) => {
                console.log('Service Worker registered:', registration);
                
                // Check for updates
                registration.addEventListener('updatefound', () => {
                    const newWorker = registration.installing;
                    newWorker.addEventListener('statechange', () => {
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            showUpdateNotification();
                        }
                    });
                });
            })
            .catch((error) => {
                console.log('Service Worker registration failed:', error);
            });
    }

    // Create install button
    createInstallButton();

    // Listen for install prompt
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        showInstallButton();
    });

    // Listen for app installed
    window.addEventListener('appinstalled', () => {
        console.log('PWA installed successfully');
        hideInstallButton();
        deferredPrompt = null;
    });

    // Check if already installed
    if (window.matchMedia('(display-mode: standalone)').matches) {
        console.log('PWA is running in standalone mode');
        hideInstallButton();
    }
}

function createInstallButton() {
    // Create install banner
    const banner = document.createElement('div');
    banner.id = 'pwa-install-banner';
    banner.style.cssText = `
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        display: none;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.2);
        z-index: 9999;
        animation: slideUp 0.3s ease-out;
    `;

    banner.innerHTML = `
        <div style="flex: 1;">
            <div style="font-weight: 600; font-size: 16px; margin-bottom: 4px;">Install SJ Fashion Hub</div>
            <div style="font-size: 13px; opacity: 0.9;">Get the app experience on your device</div>
        </div>
        <div style="display: flex; gap: 10px;">
            <button id="pwa-install-btn" style="
                background: white;
                color: #667eea;
                border: none;
                padding: 10px 20px;
                border-radius: 25px;
                font-weight: 600;
                cursor: pointer;
                font-size: 14px;
            ">Install</button>
            <button id="pwa-dismiss-btn" style="
                background: transparent;
                color: white;
                border: 1px solid white;
                padding: 10px 20px;
                border-radius: 25px;
                font-weight: 600;
                cursor: pointer;
                font-size: 14px;
            ">Later</button>
        </div>
    `;

    // Add animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }
            to {
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);

    document.body.appendChild(banner);
    installButton = banner;

    // Add event listeners
    document.getElementById('pwa-install-btn').addEventListener('click', installPWA);
    document.getElementById('pwa-dismiss-btn').addEventListener('click', () => {
        hideInstallButton();
        // Remember dismissal for 7 days
        localStorage.setItem('pwa-install-dismissed', Date.now() + (7 * 24 * 60 * 60 * 1000));
    });
}

function showInstallButton() {
    // Check if user dismissed recently
    const dismissed = localStorage.getItem('pwa-install-dismissed');
    if (dismissed && Date.now() < parseInt(dismissed)) {
        return;
    }

    if (installButton) {
        installButton.style.display = 'flex';
    }
}

function hideInstallButton() {
    if (installButton) {
        installButton.style.display = 'none';
    }
}

async function installPWA() {
    if (!deferredPrompt) {
        return;
    }

    // Show install prompt
    deferredPrompt.prompt();

    // Wait for user response
    const { outcome } = await deferredPrompt.userChoice;
    console.log(`User response: ${outcome}`);

    if (outcome === 'accepted') {
        console.log('User accepted the install prompt');
    } else {
        console.log('User dismissed the install prompt');
    }

    deferredPrompt = null;
    hideInstallButton();
}

function showUpdateNotification() {
    // Create update notification
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #4CAF50;
        color: white;
        padding: 15px 25px;
        border-radius: 50px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 15px;
        animation: slideDown 0.3s ease-out;
    `;

    notification.innerHTML = `
        <span>New version available!</span>
        <button onclick="window.location.reload()" style="
            background: white;
            color: #4CAF50;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
        ">Update</button>
    `;

    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideDown {
            from {
                transform: translate(-50%, -100%);
            }
            to {
                transform: translate(-50%, 0);
            }
        }
    `;
    document.head.appendChild(style);

    document.body.appendChild(notification);

    // Auto-hide after 10 seconds
    setTimeout(() => {
        notification.style.animation = 'slideDown 0.3s ease-out reverse';
        setTimeout(() => notification.remove(), 300);
    }, 10000);
}

// iOS Add to Home Screen detection
function isIOS() {
    return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
}

function isInStandaloneMode() {
    return ('standalone' in window.navigator) && (window.navigator.standalone);
}

// Show iOS install instructions
if (isIOS() && !isInStandaloneMode()) {
    setTimeout(() => {
        const dismissed = localStorage.getItem('ios-install-dismissed');
        if (dismissed && Date.now() < parseInt(dismissed)) {
            return;
        }

        const iosPrompt = document.createElement('div');
        iosPrompt.style.cssText = `
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 20px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 9999;
            animation: slideUp 0.3s ease-out;
        `;

        iosPrompt.innerHTML = `
            <div style="text-align: center;">
                <div style="font-weight: 600; font-size: 16px; margin-bottom: 10px;">Install SJ Fashion Hub</div>
                <div style="font-size: 14px; color: #666; margin-bottom: 15px;">
                    Tap <span style="font-size: 20px;">⎙</span> then "Add to Home Screen"
                </div>
                <button onclick="this.parentElement.parentElement.remove(); localStorage.setItem('ios-install-dismissed', Date.now() + (7 * 24 * 60 * 60 * 1000));" style="
                    background: #007AFF;
                    color: white;
                    border: none;
                    padding: 10px 30px;
                    border-radius: 25px;
                    font-weight: 600;
                    cursor: pointer;
                ">Got it</button>
            </div>
        `;

        document.body.appendChild(iosPrompt);
    }, 3000);
}

