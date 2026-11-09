import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
                display: ['Sora', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink: '#071711',
                forest: '#0f3d2e',
                moss: '#1f6b4f',
                mint: '#3ecf9a',
                fog: '#e7f3ee',
                mist: '#f4faf7',
                clay: '#c45c26',
            },
        },
    },

    plugins: [forms],
};
