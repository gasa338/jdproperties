/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: ["class"],
  content: [
    './blocks/**/*.php',
    './inc/*.php',
    './inc/classes/*.php',
    './template-parts/*.php',
    './*.php'
  ],
  prefix: "",
  theme: {
    container: {
      center: true,
      padding: "2rem",
      screens: {
        "2xl": "1400px",
      },
    },
    extend: {
      fontFamily: {
        heading: ['Prata', 'serif'],
        body: ['Inter', 'sans-serif'],
      },
      fontSize: {
        'xs': ['12px', { lineHeight: '18px' }],
        'sm': ['14px', { lineHeight: '22px' }],
        'base': ['16px', { lineHeight: '26px' }], // 🔥 više vazduha
        'lg': ['18px', { lineHeight: '28px' }],
        'xl': ['20px', { lineHeight: '30px' }],

        '2xl': ['24px', { lineHeight: '32px' }],
        '3xl': ['30px', { lineHeight: '38px' }],

        // 👇 headline tuning
        '4xl': ['45px', { lineHeight: '1.15', letterSpacing: '-0.01em' }],
        '5xl': ['70px', { lineHeight: '1.05', letterSpacing: '-0.02em' }],

        // H1
        'h1-mobile': ['40px', { lineHeight: '44px', letterSpacing: '-0.01em' }],
        'h1-tablet': ['44px', { lineHeight: '48px', letterSpacing: '-0.015em' }],
        'h1-desktop': ['52px', { lineHeight: '60px', letterSpacing: '-0.02em' }],

        // H2
        'h2-mobile': ['24px', { lineHeight: '32px' }],
        'h2-tablet': ['28px', { lineHeight: '36px' }],
        'h2-desktop': ['34px', { lineHeight: '42px', letterSpacing: '-0.01em' }],

        // H3
        'h3-mobile': ['20px', { lineHeight: '28px' }],
        'h3-tablet': ['22px', { lineHeight: '30px' }],
        'h3-desktop': ['24px', { lineHeight: '32px' }],

        'h4-mobile': ['18px', { lineHeight: '22px' }],
        'h4-tablet': ['20px', { lineHeight: '24px' }],
        'h4-desktop': ['22px', { lineHeight: '26px' }],

        'h5-mobile': ['18px', { lineHeight: '20px' }],
        'h5-tablet': ['18px', { lineHeight: '24px' }],
        'h5-desktop': ['18px', { lineHeight: '22px' }],

        'h6-mobile': ['14px', { lineHeight: '18px' }],
        'h6-tablet': ['15px', { lineHeight: '19px' }],
        'h6-desktop': ['16px', { lineHeight: '20px' }],
      },
      colors: {
        border: "hsl(var(--border))",
        input: "hsl(var(--input))",
        ring: "hsl(var(--ring))",
        foreground: "hsl(var(--foreground))",
        background: {
          DEFAULT: "hsl(var(--background))",
          soft: "hsl(var(--background-soft))",
          muted: "hsl(var(--background-muted))",
        },
        primary: {
          DEFAULT: "hsl(var(--primary))",
          foreground: "hsl(var(--primary-foreground))",
        },
        secondary: {
          DEFAULT: "hsl(var(--secondary))",
          foreground: "hsl(var(--secondary-foreground))",
        },
        destructive: {
          DEFAULT: "hsl(var(--destructive))",
          foreground: "hsl(var(--destructive-foreground))",
        },
        muted: {
          DEFAULT: "hsl(var(--muted))",
          foreground: "hsl(var(--muted-foreground))",
        },
        accent: {
          DEFAULT: "hsl(var(--accent))",
          foreground: "hsl(var(--accent-foreground))",
        },
        popover: {
          DEFAULT: "hsl(var(--popover))",
          foreground: "hsl(var(--popover-foreground))",
        },
        card: {
          DEFAULT: "hsl(var(--card))",
          foreground: "hsl(var(--card-foreground))",
        },
        hero: {
          DEFAULT: "hsl(var(--hero-gradient))"
        },
        gold: {
          DEFAULT: "hsl(var(--gold))",
          light: "hsl(var(--gold-light))",
          glow: "hsl(var(--gold-glow))",
        },
        cream: {
          DEFAULT: "hsl(var(--cream))",
          dark: "hsl(var(--cream-dark))",
        },
        slate: "hsl(var(--slate))",
      },
      letterSpacing: {
        tight: '-0.02em',
        normal: '0em',
        wide: '0.05em',
        luxury: '0.08em', // 👈 za male caps / labele
      },
      borderRadius: {
        lg: "var(--radius)",
        md: "calc(var(--radius) - 2px)",
        sm: "calc(var(--radius) - 4px)",
      },
      keyframes: {
        "accordion-down": {
          from: { height: "0" },
          to: { height: "var(--radix-accordion-content-height)" },
        },
        "accordion-up": {
          from: { height: "var(--radix-accordion-content-height)" },
          to: { height: "0" },
        },
        "fade-in": {
          from: { opacity: "0", transform: "translateY(20px)" },
          to: { opacity: "1", transform: "translateY(0)" },
        },
      },
      animation: {
        "accordion-down": "accordion-down 0.2s ease-out",
        "accordion-up": "accordion-up 0.2s ease-out",
        "fade-in": "fade-in 0.6s ease-out forwards",
      },
    },
  },
  plugins: [require("tailwindcss-animate")],
}
