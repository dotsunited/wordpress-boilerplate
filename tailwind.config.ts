import type { Config } from 'tailwindcss';
import plugin from 'tailwindcss/plugin';
import defaultTheme from 'tailwindcss/defaultTheme';
import { CSSRuleObject } from 'tailwindcss/types/config';

export default {
    content: [
        './public/wp-content/themes/wordpress-boilerplate/**/*.+(html|php)',
        './assets/main/**/*.+(css|scss|js|ts|jsx|tsx)',
    ],
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['"Source Serif 4"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                dotsunited: {
                    red: {
                        50: '#fdf5ef',
                        100: '#f9e7db',
                        200: '#f2ccb6',
                        300: '#eaaa87',
                        400: '#e17e56',
                        500: '#da5e35',
                        600: '#c9462a',
                        700: '#a93525',
                        800: '#872d25',
                        900: '#6d2721',
                        950: '#3b120f',
                    },
                },
            },
        },
    },
    safelist: [
        // Add Gutenberg color utility classes to safelist
        { pattern: /^has-[\w-]+-background-color$/ },
        { pattern: /^has-[\w-]+-color$/ },
        { pattern: /^has-[\w-]+-border-color$/ }
    ],
    plugins: [
        // Add Gutenberg color utility classes
        plugin(({ addUtilities, config }) => {
            const colors = config('theme.colors');

            const generateUtilities = (colors: { [key: string]: string | { [key: string]: string } }): { [key: string]: CSSRuleObject }[] => {
                const utilities: { [key: string]: CSSRuleObject }[] = [];

                const generateUtility = (prefix: string, value: string | { [key: string]: string }) => {
                    if (typeof value === 'string') {
                        utilities.push({
                            [`.has-${prefix}-color`]: { 'color': value },
                            [`.has-${prefix}-background-color`]: { 'background-color': value },
                            [`.has-${prefix}-border-color`]: { 'border-color': value },
                        });
                    } else if (typeof value === 'object') {
                        Object.keys(value).forEach(subKey => {
                            const subValue = value[subKey];
                            const subPrefix = `${prefix}-${subKey}`;

                            generateUtility(subPrefix, subValue);
                        });
                    }
                };

                Object.keys(colors).forEach(key => {
                    const value = colors[key];
                    generateUtility(key, value);
                });

                return utilities;
            };

            const utilities = generateUtilities(colors);

            addUtilities(utilities);
        })
    ],
} satisfies Config;
