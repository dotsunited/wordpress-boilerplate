import { defineConfig } from 'vite';

export default defineConfig({
    publicDir: false,
    base: './',
    build: {
        rollupOptions: {
            input: {
                main: './assets/gutenberg/index.js',
            },
            output: {
                entryFileNames: 'blocks.js',
                chunkFileNames: 'blocks.js',
                assetFileNames: 'blocks.[ext]',
            },
            external: ['react', 'wp'],
        },
        cssMinify: 'lightningcss',
        outDir: './public/wp-content/mu-plugins/wordpress-boilerplate/modules/gutenberg/blocks/assets',
    },
});
