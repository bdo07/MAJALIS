import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Cairo', 'Tajawal', ...defaultTheme.fontFamily.sans],
                quran: ['"Amiri Quran"', 'Amiri', 'Traditional Arabic', 'Scheherazade New', 'serif'],
                serif: ['Amiri', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                emerald: {
                    50: '#f2f8f4',
                    100: '#e1eee5',
                    200: '#c5ddd0',
                    300: '#9dc3b0',
                    400: '#6fa38b',
                    500: '#4d876f',
                    600: '#386c57',
                    700: '#2c5444',
                    800: '#254438',
                    900: '#20392f',
                    950: '#0f201a',
                },
                stone: {
                    50: '#faf9f6',
                    100: '#f4f2ec',
                    200: '#e8e5dc',
                    300: '#d7d2c3',
                    400: '#b8b09b',
                    500: '#998e77',
                    600: '#7e725d',
                    700: '#645a4a',
                    800: '#524a3e',
                    900: '#453f35',
                    950: '#26221c',
                }
            }
        },
    },

    plugins: [forms],
};
