/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'custom-blue': '#5f6ec0',
      }
    },
  },
  variants: {
    extend: {
      placeholderColor: ['responsive', 'dark', 'focus', 'hover', 'active'],
    },
  },
  plugins: [],
}