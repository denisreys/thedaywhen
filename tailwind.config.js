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
        'mylightgray': '#F3F3F3',
      },
      boxShadow: {
        menu: '0px -4px 4px rgba(0, 0, 0, 0.05)',
      },
      screens: {
        'xs': '420px',
      }
    },
  },
  plugins: [],
}

