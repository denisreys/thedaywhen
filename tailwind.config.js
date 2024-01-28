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
        'main--dark': '#8c819c',
        'bg--dark': '#28282b',//#2e2e30
        'block-bg': '#F9F9F9',
        'block-bg--dark': '#2e2e31',
        'block-border': '#f4f4f4',
        'block-border--dark': '#262629',
        
        'small-text': '#bdbdbd',
        'small-text--dark': '#8f8f8f',
        'text': '#222',
        'text--dark': '#e9e6ec',
      },
      boxShadow: {
        menu: '0px -3px 4px rgba(0, 0, 0, 0.05)',
        activeday: '0px -5px 5px rgba(0, 0, 0, 0.05)',
      },
      screens: {
        'xs': '410px',
      }
    },
  },
  plugins: [],
}

