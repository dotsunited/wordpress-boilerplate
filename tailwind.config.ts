import type { Config } from 'tailwindcss';
import plugin from 'tailwindcss/plugin';
import defaultTheme from 'tailwindcss/defaultTheme';
import { CSSRuleObject } from 'tailwindcss/types/config';

export default {
    content: [
        './public/wp-content/themes/wordpress-boilerplate/**/*.+(html|php)',
    ],
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dotsunited: {
                    red: {
                        500: '#c9462a',
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
        plugin(function ({ addUtilities, config }) {
            const colors = config('theme.colors');

            const utilities: { [key: string]: CSSRuleObject }[] = Object.keys(colors).reduce((acc: { [key: string]: CSSRuleObject }[], key) => {
                const value = colors[key];

                if (typeof value === 'string') {
                    acc.push({
                        [`.has-${key}-color`]: { 'color': value },
                        [`.has-${key}-background-color`]: { 'background-color': value },
                        [`.has-${key}-border-color`]: { 'border-color': value },
                    });
                } else if (typeof value === 'object') {
                    Object.keys(value).forEach(subKey => {
                        const subValue = value[subKey];

                        if (typeof subValue === 'string') {
                            acc.push({
                                [`.has-${key}-${subKey}-color`]: { 'color': subValue },
                                [`.has-${key}-${subKey}-background-color`]: { 'background-color': subValue },
                                [`.has-${key}-${subKey}-border-color`]: { 'border-color': subValue },
                            });
                        } else if (typeof subValue === 'object') {
                            Object.keys(subValue).forEach(subSubKey => {
                                const subSubValue = subValue[subSubKey];

                                if (typeof subSubValue === 'string') {
                                    acc.push({
                                        [`.has-${key}-${subKey}-${subSubKey}-color`]: { 'color': subSubValue },
                                        [`.has-${key}-${subKey}-${subSubKey}-background-color`]: { 'background-color': subSubValue },
                                        [`.has-${key}-${subKey}-${subSubKey}-border-color`]: { 'border-color': subSubValue },
                                    });
                                }
                            });
                        }
                    });
                }

                return acc;
            }, []);

            addUtilities(utilities);
        }),
    ],
} satisfies Config;
