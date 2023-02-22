const safelist = require('./tailwind.safelist')
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    safelist: safelist,
    theme: {
        extend: {},
    },
    plugins: [],
}
