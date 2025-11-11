import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
        colors: {
            // Colores personalizados basados en el template Swigo
            primary: {
            DEFAULT: '#FF6B28',
            light: '#FF8C50',
            dark: '#CC541F',
            },
            secondary: {
            DEFAULT: '#4ECDC4',
            light: '#6FEEDA',
            dark: '#3DAA95',
            },
            accent: {
            DEFAULT: '#FFE66D',
            light: '#FFF38A',
            dark: '#CCB85A',
            },
            neutral: {
            DEFAULT: '#1E1E1E',
            light: '#333333',
            dark: '#0F0F0F',
            },
            background: {
            DEFAULT: '#F9F9F9',
            light: '#FFFFFF',
            dark: '#EFEFEF',
            },
        },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
