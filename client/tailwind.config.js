/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        // Custom theme colors - central manageted
        primary: {
          50: "#f0f4ff",
          100: "#e0e9ff",
          200: "#c7d6fe",
          300: "#a5b8fc",
          400: "#8292f8",
          500: "#6366f1",
          600: "#4f46e5",
          700: "#4338ca",
          800: "#3730a3",
          900: "#312e81",
        },
        // Brand specific colors
        brand: {
          purple: {
            600: "#7c3aed",
            700: "#6d28d9",
            800: "#5b21b6",
          },
        },
      },
    },
  },
  plugins: [],
};
