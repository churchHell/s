const colors = require('tailwindcss/colors')

module.exports = {
  mode: 'jit',                           //ADD THIS LINE
  purge: [                               //CONFIGURE CORRECTLY
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './config/*.php',
  ], 
  content: [],
  theme: {
    container: {
      center: true,
      padding: '2rem'
    },
    extend: {
      colors: {
        transparent: 'transparent',
        current: 'currentColor',
        default: {
          dark: colors.blueGray[800],
          DEFAULT: colors.blueGray[700],
          light: colors.blueGray[600],
          semilight: colors.blueGray[200],
          lightest: colors.blueGray[100],
        },
        primary: {
          dark: colors.blue[600],
          DEFAULT: colors.blue[500],
          light: colors.blue[400]
        },
        accent: {
          dark: colors.orange[600],
          DEFAULT: colors.orange[500],
          light: colors.orange[400],
          lightest: colors.orange[200]
        },
        info: {
          darkest: colors.blue[800],
          dark: colors.blue[300],
          DEFAULT: colors.blue[200]
        },
        error: {
          darkest: colors.red[800],
          dark: colors.red[300],
          DEFAULT: colors.red[200],
        },
        success: {
          darkest: colors.green[800],
          dark: colors.green[300],
          DEFAULT: colors.green[200]
        }
      }
    },
  },
  plugins: [],
}
