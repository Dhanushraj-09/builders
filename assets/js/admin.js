/**
 * Admin Panel JavaScript
 */
document.addEventListener('DOMContentLoaded', () => {
    // Image upload preview
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const preview = this.parentElement.querySelector('.preview');
            if (preview) {
                preview.innerHTML = '';
                Array.from(this.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-20 h-20 object-cover rounded-lg border border-white/10 mt-2';
                            preview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    });

    // Auto-hide flash messages
    const flashMessages = document.querySelectorAll('div.border.mb-6[class*="bg-green-500/10"], div.border.mb-6[class*="bg-red-500/10"]');
    flashMessages.forEach(msg => {
        setTimeout(() => {
            msg.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            msg.style.opacity = '0';
            msg.style.transform = 'translateY(-10px)';
            setTimeout(() => msg.remove(), 500);
        }, 5000);
    });
});
