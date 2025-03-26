import ClipboardJS from 'clipboard';
import 'preline';
import 'preline/dist/helper-clipboard.js';
import './bootstrap';
import 'preline';
import Toastify from 'toastify-js';
window.Toastify = Toastify;


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Initialize Clipboard for buttons with class ".js-clipboard-example"
const clipboard = new ClipboardJS('.js-clipboard-example');

clipboard.on('success', function(e) {
    const btn = e.trigger;
    const defaultIcon = btn.querySelector('.js-clipboard-default');
    const successIcon = btn.querySelector('.js-clipboard-success');

    if (defaultIcon && successIcon) {
        defaultIcon.classList.add('hidden');
        successIcon.classList.remove('hidden');

        setTimeout(() => {
            successIcon.classList.add('hidden');
            defaultIcon.classList.remove('hidden');
        }, 1500);
    }

    console.log('Copied!');
    e.clearSelection();
});

