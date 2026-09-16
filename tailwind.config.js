import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
            colors: {
                primary: {
                    DEFAULT: '#0D9488',
                    dark: '#0F766E',
                    light: '#14B8A6',
                },
                accent: '#FBBF24',
                'accent-warm': '#FB923C',
                secondary: '#EEF7F6',
                danger: '#DC2626',
                success: '#16A34A',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Sora', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
                'pulse-soft': {
                    '0%, 100%': { opacity: 1 },
                    '50%': { opacity: 0.6 },
                },
                'float-up': {
                    '0%': { opacity: 0, transform: 'translateY(12px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
                marquee: {
                    '0%': { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
            },
            animation: {
                shimmer: 'shimmer 2.5s linear infinite',
                'pulse-soft': 'pulse-soft 2.4s ease-in-out infinite',
                'float-up': 'float-up 0.5s ease-out both',
                marquee: 'marquee 28s linear infinite',
            },
        },
    },

    plugins: [forms, typography],
};
