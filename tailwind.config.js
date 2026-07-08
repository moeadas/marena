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
            },
            colors: {
                'marena-teal': '#2C5F5D',
                'marena-teal-deep': '#1F4745',
                'marena-teal-soft': '#3E7A78',
                'marena-sage': '#8FB5A8',
                'marena-sage-light': '#A8C5B8',
                'marena-sage-mist': '#D4E3DC',
                'marena-tan': '#D4A574',
                'marena-tan-light': '#E8C9A0',
                'marena-cream': '#F2EADD',
                'marena-cream-deep': '#E8DCC6',
                'marena-ivory': '#FAF5EB',
                'marena-success': '#6B9E7A',
                'marena-warn': '#D4A574',
                'marena-danger': '#C65D57',
                'marena-info': '#3E7A78',
                'marena-ink': '#1F2D2C',
                'marena-ink-70': '#3F5453',
                'marena-ink-50': '#6B807E',
                'marena-ink-30': '#A6B4B2',
                'marena-ink-10': '#E3E9E7',
            },
            borderRadius: {
                'xl': '0.875rem',
                '2xl': '1.25rem',
            },
            boxShadow: {
                'soft': '0 2px 8px rgba(31, 45, 44, 0.06)',
                'card': '0 1px 3px rgba(31, 45, 44, 0.08), 0 1px 2px rgba(31, 45, 44, 0.04)',
                'elevated': '0 4px 16px rgba(31, 45, 44, 0.1)',
            },
        },
    },

    plugins: [forms],
};