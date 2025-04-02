/**
 * Generates Tailwind CSS utilities for WordPress colors.
 *
 * This module generates Tailwind CSS utilities for WordPress colors. It creates
 * classes that apply colors to elements based on their prefixes.
 *
 * @module wp-utilities
 */
module.exports = function ({ addUtilities, config }) {
    const generateUtilities = (colors: { [key: string]: string | { [key: string]: string } }) => {
        const utilities: { [key: string]: { [key: string]: string } }[] = [];

        const generateUtility = (prefix: string, value: string | { [key: string]: string }) => {
            if (typeof value === 'string') {
                utilities.push({
                    [`.has-${prefix}-color`]: { color: value },
                    [`.has-${prefix}-background-color`]: { 'background-color': value },
                    [`.has-${prefix}-border-color`]: { 'border-color': value },
                });
            }
            else if (typeof value === 'object') {
                Object.keys(value).forEach((subKey) => {
                    const subValue = value[subKey];
                    const subPrefix = `${prefix}-${subKey}`;

                    generateUtility(subPrefix, subValue);
                });
            }
        };

        Object.keys(colors).forEach((key) => {
            const value = colors[key];
            generateUtility(key, value);
        });

        return utilities;
    };

    const colors = config('theme.colors');
    const utilities = generateUtilities(colors);

    addUtilities(utilities);
};
