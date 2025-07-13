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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                nastaliq: ['Noto Nastaliq Urdu', 'sans-serif'],
            },
            lineHeight: {
                'nastaliq': '2',
            },
            height: {
                "body-height": `calc(100vh - 65px)`,
            },
            colors: {
                primary: {
                    50: "#1F1629",
                    100: "#404040",
                    150: "#1F2029",
                },
            }
        },
    },

    plugins: [forms],
};
