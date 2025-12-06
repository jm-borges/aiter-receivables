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
                sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            colors: {
                'page-bg': '#211748',
                'sidebar-bg': '#E5E1E7',
                'custom-blue': '#69549F',
                'custom-blue-hover': '#211748',
            },
            backgroundColor: theme => ({
                'custom-blue-hover': '#211748',
            }),
        },
    },

    plugins: [forms],
};
