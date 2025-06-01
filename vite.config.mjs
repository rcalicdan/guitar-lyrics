import { defineConfig } from 'vite';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default defineConfig(({ command }) => {
    const isProduction = command === 'build';

    return {
        base: isProduction ? '/dist/' : '/',
        build: {
            outDir: 'dist',
            emptyOutDir: true,
            manifest: true,
            rollupOptions: {
                input: {
                    'resources/js/app.js': resolve(__dirname, 'resources/js/app.js'),
                    'resources/css/app.css': resolve(__dirname, 'resources/css/app.css'),
                    'resources/css/app/custom.css': resolve(__dirname, 'resources/css/app/custom.css'),
                    'resources/css/app/custom-trix.css': resolve(__dirname, 'resources/css/app/custom-trix.css'),
                    'resources/css/app/homepage.css': resolve(__dirname, 'resources/css/app/homepage.css'),
                },
            },
        },
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