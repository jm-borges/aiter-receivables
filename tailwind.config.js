import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './public/assets/scripts/**/*.js',
    ],

    safelist: [
        'w-6',
        'w-full',
        'max-w-[32px]',
        'rounded-full',
        'transition-all',
        'flex',
        'flex-col',
        'items-center',
        'justify-end',
        'h-full',
        'flex-1',
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
        },
    },

    plugins: [forms],
};
