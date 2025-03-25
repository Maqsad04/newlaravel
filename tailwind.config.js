/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.{html,js,jsx,ts,tsx,php}",
      "./components/**/*.{js,jsx,ts,tsx}",
      "./views/**/*.{php}",
    ],
    theme: {
      extend: {
        animation: {
          'fade-in': 'fadeIn 0.8s ease-out',
        },
        keyframes: {
          fadeIn: {
            '0%': { opacity: '0', transform: 'translateY(10px)' },
            '100%': { opacity: '1', transform: 'translateY(0)' },
          },
        },
      },
    },
    plugins: [],
    prefix: 'tw-',
    corePlugin: { preflight: false },
  };