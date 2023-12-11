/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'main': '#C1B2D9',
        'mylightgray': '#F9F9F9',
      },
      boxShadow: {
        menu: '0px -3px 4px rgba(0, 0, 0, 0.05)',
        activeday: '0px -5px 5px rgba(0, 0, 0, 0.05)',
      },
      screens: {
        'xs': '420px',
      }
    },
  },
  plugins: [],
}

