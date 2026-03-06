import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', 'Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                'sakura': {
                    50: '#fdf4f8',
                    100: '#fce7f1',
                    200: '#fad0e4',
                    300: '#f7abd0',
                    400: '#f27bb5',
                    500: '#eb4d98',
                    600: '#d92c7b',
                    700: '#b91d61',
                    800: '#991a52',
                    900: '#801847',
                    950: '#4e0a27',
                },
                'matcha': {
                    50: '#f5f8f5',
                    100: '#e5eee6',
                    200: '#cbddce',
                    300: '#a5c4ab',
                    400: '#79a582',
                    500: '#568761',
                    600: '#406b4a',
                    700: '#34553d',
                    800: '#2b4432',
                    900: '#24382a',
                    950: '#131e17',
                },
            },
            borderRadius: {
                '4xl': '2rem',
                '5xl': '3rem',
            },
            boxShadow: {
                'glass': '0 4px 30px rgba(0, 0, 0, 0.1)',
                'glass-sm': '0 2px 10px rgba(0, 0, 0, 0.05)',
                'glow': '0 0 15px rgba(255, 209, 220, 0.5)',
            }
        },
    },

    plugins: [forms],
};
