import { defineConfig } from 'vite';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default defineConfig(({ command }) => {
    const isProduction = command === 'build';

    return {
        base: isProduction ? '/build/' : '/',
        build: {
            outDir: 'public/build',
            emptyOutDir: true,
            manifest: true,
            rollupOptions: {
                input: {
                    app: resolve(__dirname, 'resources/js/app.js'),
                    styles: resolve(__dirname, 'resources/css/app.css'),
                },
                output: {
                    assetFileNames: 'assets/[name]-[hash][extname]',
                    chunkFileNames: 'assets/[name]-[hash].js',
                    entryFileNames: 'assets/[name]-[hash].js',
                }
            },
        },
        publicDir: 'public/static',
        server: {
            host: 'localhost',
            port: 3000,
            strictPort: true,
            hmr: {
                host: 'localhost',
            },
            proxy: {
                '/api': {
                    target: 'http://localhost:8080',
                    changeOrigin: true,
                },
            },
        },
        css: {
            devSourcemap: true,
        },
        plugins: [],
        resolve: {
            alias: {
                '@': resolve(__dirname, 'resources'),
                '@js': resolve(__dirname, 'resources/js'),
                '@css': resolve(__dirname, 'resources/css'),
            },
        },
        optimizeDeps: {
            include: [],
        },
    };
});