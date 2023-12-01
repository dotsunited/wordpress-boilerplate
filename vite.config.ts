import { defineConfig } from 'vite';
import { manualChunksPlugin } from 'vite-plugin-webpackchunkname';

export default defineConfig({
    publicDir: false,
    base: './',
    build: {
        manifest: true,
        rollupOptions: {
            input: {
                main: './assets/main',
                icons: './assets/icons/index.css',
                symbolDefs: './assets/icons/symbol-defs.svg',
            },
            output: {
                entryFileNames: 'js/[name].[hash].js',
                chunkFileNames: 'js/[name].[hash].js',
                assetFileNames: ({ name }) => {
                    if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')) {
                        return 'img/[name].[hash].[ext]';
                    }

                    if (/\.css$/.test(name ?? '')) {
                        return 'css/[name].[hash].[ext]';
                    }

                    // default value
                    // ref: https://rollupjs.org/guide/en/#outputassetfilenames
                    return '[name].[hash].[ext]';
                },
            },
        },
        cssMinify: 'lightningcss',
        outDir: './public/wp-content/themes/wordpress-boilerplate/assets',
    },
    plugins: [manualChunksPlugin()],
});
