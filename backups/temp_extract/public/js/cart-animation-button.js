function initCartAnimationButtons() {
    document.querySelectorAll('.cart-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Don't trigger if already animating or completed
            if (button.classList.contains('adding') || button.classList.contains('added')) {
                return;
            }
            
            // Start animation
            button.classList.add('adding');
            
            // After animation completes, show success state
            setTimeout(() => {
                button.classList.remove('adding');
                button.classList.add('added');
                
                // Trigger custom event
                const event = new CustomEvent('cartAnimationComplete', {
                    detail: { button: button }
                });
                button.dispatchEvent(event);
                
                // Reset after 3 seconds
                setTimeout(() => {
                    resetCartButton(button);
                }, 3000);
                
            }, 1000); // Duration of adding animation
        });
    });
}

function resetCartButton(button) {
    button.classList.remove('adding', 'added');
}

function resetAllCartButtons() {
    document.querySelectorAll('.cart-button').forEach(button => {
        resetCartButton(button);
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initCartAnimationButtons();
});

// Re-initialize for dynamically added buttons
function reinitCartAnimationButtons() {
    initCartAnimationButtons();
}
