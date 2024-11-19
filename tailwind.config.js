import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        fontFamily: {
            sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
        },
        extend: {},
    },
    plugins: [],
}
