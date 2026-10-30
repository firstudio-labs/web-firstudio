const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/css/**/*.css',
        './app/View/Components/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                navy: { DEFAULT: '#001F54', dark: '#00122e' },
                primary: { DEFAULT: '#003CA3', hover: '#002f80' },
                accentSoft: '#EAF1FF',
                sky: '#70A5FF',
                paper: '#F8F9FA',
                tint: '#EAF1FF',
                ink: '#0B1B3A',
                muted: '#5B6B8C',
                line: '#DCE4F2',
                figmaGray: '#D9D9D9',
            },
            fontFamily: {
                primary: ['Poppins', ...defaultTheme.fontFamily.sans],
                secondary: ['Poppins', ...defaultTheme.fontFamily.sans],
                mono: ['"IBM Plex Mono"', ...defaultTheme.fontFamily.mono],
            },
            maxWidth: { page: '83rem' },
        },
    },
    plugins: [],
};
