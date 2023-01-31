/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './public/wp-content/themes/wordpress-boilerplate/**/*.+(html|php)',
    ],
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {},
    },
    plugins: [],
};
