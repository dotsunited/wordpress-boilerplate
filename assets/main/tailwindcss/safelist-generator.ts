import fs from 'node:fs';
import path from 'node:path';
import tailwindColors from 'tailwindcss/colors';

function generateSafelist(): void {
    const configPath = path.join(__dirname, 'config.css');

    try {
        const config = fs.readFileSync(configPath, 'utf8');

        // Extract custom colors
        const customColors: Record<string, string> = {};
        const colorRegex = /--color-([\w-]+):\s*([#\w()]+);/g;
        let match: RegExpExecArray | null;

        // eslint-disable-next-line no-cond-assign
        while ((match = colorRegex.exec(config)) !== null) {
            const colorName = match[1];
            customColors[colorName] = match[2];
        }

        // Merge custom colors with default Tailwind colors
        const allColors: Record<string, any> = { ...tailwindColors, ...customColors };

        const patterns: string[] = [
            'has-{color}-background-color',
            'has-{color}-color',
            'has-{color}-border-color',
        ];

        const safelist: string[] = [];

        function generateSafelistEntries(colorValue: any, colorPath: string[] = []) {
            if (typeof colorValue === 'object' && colorValue !== null) {
                Object.keys(colorValue).forEach((key) => {
                    generateSafelistEntries(colorValue[key], [...colorPath, key]);
                });
            }
            else if (typeof colorValue === 'string') {
                const colorName = colorPath.join('-');
                patterns.forEach((pattern) => {
                    safelist.push(pattern.replace('{color}', colorName));
                });
            }
        }

        Object.keys(allColors).forEach((color) => {
            generateSafelistEntries(allColors[color], [color]);
        });

        fs.writeFileSync(path.join(__dirname, 'safelist.txt'), `${safelist.join('\n')}\n`);
    }
    catch (error) {
        console.error('Error generating safelist:', error);
    }
}

generateSafelist();
