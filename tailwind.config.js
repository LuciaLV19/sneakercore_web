import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                title: ['var(--font-title)'],
                main: ['var(--font-main)'],
            },
            colors: {
                'brand-primary': 'var(--brand-primary)',
                'brand-primary-soft': 'var(--brand-primary-soft)',
                'brand-secondary': 'var(--brand-secondary)',
                'brand-secondary-soft': 'var(--brand-secondary-soft)',
                'bg-white': 'var(--bg-white)',
                'bg-light': 'var(--bg-light)',
                'dark': 'var(--dark)',
                'muted': 'var(--muted)',
                'light': 'var(--light)',
                'border-soft': 'var(--border-soft)',
                'success': 'var(--success)',
                'error': 'var(--error)',
                'warning': 'var(--warning)',
                'info': 'var(--info)',
                'info-hover': 'var(--info-hover)',
                'input-bg': 'var(--input-bg)',
                'input-bg-focus': 'var(--input-bg-focus)',
                'input-text': 'var(--input-text)',
                'input-border': 'var(--input-border)',
                'input-placeholder': 'var(--input-placeholder)',
            },
        },
    },

    plugins: [forms],
};
