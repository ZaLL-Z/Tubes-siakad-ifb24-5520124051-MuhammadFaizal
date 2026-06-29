(() => {
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-password-toggle');
            const input = document.getElementById(targetId);
            const icon = button.querySelector('i');

            if (!input) return;

            const showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';

            if (icon) {
                icon.className = showPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            }
        });
    });
})();
