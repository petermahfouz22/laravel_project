import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const email = form.querySelector('#email');
            const password = form.querySelector('#password');
            if (email && !email.value.includes('@')) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                email.focus();
            }
            if (password && password.value.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                password.focus();
            }
        });
    });
});

forms.forEach(form => {
    form.addEventListener('submit', () => {
        const button = form.querySelector('button');
        button.disabled = true;
        button.textContent = 'Processing...';
    });
});