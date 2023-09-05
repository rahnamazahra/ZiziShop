import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                color1: "#a4a4a4",
                color2: "#f2f0ea",
                color3: "#010101",
                color4: "#edcf5d",
            },
            borderColor: {
                color4: "#edcf5d",
            },
            backgroundColor: {
                color4: "#edcf5d",
            },
            textColor: {
                color4: "#edcf5d",
                color2: "#f2f0ea",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
