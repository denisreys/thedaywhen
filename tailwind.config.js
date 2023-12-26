/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'main': '#C1B2D9',
        'block-bg': '#F9F9F9',
        'block-bg--dark': '#3f3f3f',
        'block-bg-border': '#F9F9F9',
        'block-bg-border--dark': '#2d2d2d',
        'bg--dark': '#2f2f2f',
        'small-text': '#bdbdbd',
        'small-text--dark': '#8f8f8f',
        'text--dark': '#e9e8e8',
        
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

