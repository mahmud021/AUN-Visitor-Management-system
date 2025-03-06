import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        'node_modules/preline/dist/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#000000',
                brand: {
                    50: '#f7f7f7',
                    100: '#ededed',
                    200: '#e2e2e2',
                    300: '#d0d0d0',
                    400: '#a8a8a8',
                    500: '#7a7a7a',
                    600: '#4d4d4d',
                    700: '#3b3b3b',
                    800: '#2b2b2b',
                    900: '#1a1a1a',
                },
            },
        },
    },
    plugins: [
        require('preline/plugin'),
        require('@tailwindcss/forms'),
    ],
};
