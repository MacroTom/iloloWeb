const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        fontFamily: {
            sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            Poppins: ['Poppins', 'sans-serif', 'Inter'],
            Inter: ['Inter', 'sans-serif']
        },
      },
    },
    plugins: [
        require('tailwind-scrollbar-hide')
    ],
  }
