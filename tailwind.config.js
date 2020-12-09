const colors = require('tailwindcss/colors')
module.exports = {
  purge: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        colors: {
            primary: {
                DEFAULT: colors.indigo["500"],
                lighter: colors.indigo["200"],
                darker: colors.indigo["600"],
            },
            secondary: {
                DEFAULT: colors.gray["300"],
                lighter: colors.gray["200"],
                dark: colors.gray["400"],
                darker: colors.gray["600"],

            },
            accent: {
                DEFAULT: colors.pink["500"],
                darker: colors.pink["600"],
                lighter: colors.pink["200"],
            },
            warning: {
                DEFAULT: colors.yellow["500"],
                darker: colors.yellow["600"],
                lighter: colors.yellow["200"],
            },
            success: {
                DEFAULT: colors.green["500"],
                lighter: colors.green["200"],
                darker: colors.green["600"]
            },
            danger: {
                lighter: colors.red['200'],
                DEFAULT: colors.red["500"],
                darker: colors.red["600"],
            }
        },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
      require("@tailwindcss/forms"),
      require("@tailwindcss/ui"),
  ],
}
