/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.html", "./*.php"],
  theme: {
    extend: {
      colors: {
        primary: "#FFF7E9",
        secondary: "#181D50",
        third: "#FF731D",
        lightBlue: "#5F9DF7",
      },
      width: {
        '491': '30.6875rem',
      },
      padding: {
        '18': '4.5rem',
      },
      fontFamily: {
        'lack': 'Lack, sans-serif',
        'inter': 'Inter, sans-serif',
      }
    },
  },
  plugins: [],
}

