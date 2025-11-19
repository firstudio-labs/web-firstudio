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
                brand: {
                    DEFAULT: '#fdfdfd',
                    accent: '#3b82f6',
                },
                surface: '#000000',
                surfaceDim: '#0a0a0a',
            },
            fontFamily: {
                primary: ['Poppins', ...defaultTheme.fontFamily.sans],
                secondary: ['"Clear Sans"', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};

