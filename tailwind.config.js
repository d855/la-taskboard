/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                default: "var(--text-default-color)"
            },
            backgroundColor: {
                page: "var(--page-background-color)",
                card: 'var(--card-background-color)',
                button: 'var(--button-background-color)',
                nav: 'var(--nav-background-color)'
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
