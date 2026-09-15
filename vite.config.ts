import { rmSync, writeFileSync } from 'node:fs';
import path from 'node:path';
import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';

const devServerHost = 'localhost';
const devServerPort = 5174;
const devServerOrigin = `http://${devServerHost}:${devServerPort}`;
const devServerFile = path.resolve(import.meta.dirname, './public/wp-content/themes/wordpress-boilerplate/.vite-dev-server');

export default defineConfig({
    publicDir: false,
    base: './',
    server: {
        host: '0.0.0.0',
        port: devServerPort,
        strictPort: true,
        origin: devServerOrigin,
        cors: {
            origin: 'http://localhost:8080',
        },
        hmr: {
            host: devServerHost,
            port: devServerPort,
        },
    },
    resolve: {
        alias: {
            '@lib': path.resolve(import.meta.dirname, './assets/lib'),
            '@main': path.resolve(import.meta.dirname, './assets/main'),
            '@gutenberg': path.resolve(import.meta.dirname, './assets/gutenberg'),
        },
    },
    build: {
        manifest: true,
        rollupOptions: {
            input: {
                main: './assets/main',
            },
            output: {
                entryFileNames: 'js/[name].[hash].js',
                chunkFileNames: 'js/[name].[hash].js',
                assetFileNames: ({ name }) => {
                    if (/\.(?:gif|jpe?g|png|svg)$/.test(name ?? '')) {
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
    css: {
        transformer: 'lightningcss',
        lightningcss: {
            drafts: {
                customMedia: true,
            },
        },
    },
    plugins: [
        tailwindcss(),
        {
            name: 'wordpress-dev-server',
            configureServer(server) {
                const removeDevServerFile = () => {
                    rmSync(devServerFile, { force: true });
                };

                const writeDevServerFile = () => {
                    writeFileSync(devServerFile, devServerOrigin);
                };

                if (server.httpServer?.listening) {
                    writeDevServerFile();
                } else {
                    server.httpServer?.once('listening', writeDevServerFile);
                }
                server.httpServer?.once('close', removeDevServerFile);
                process.once('exit', removeDevServerFile);
                process.once('SIGINT', removeDevServerFile);
                process.once('SIGTERM', removeDevServerFile);
            },
        },
    ],
});
