import { defineConfig } from 'vite';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';
import { writeFileSync, unlinkSync, existsSync } from 'fs';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

function hotFilePlugin() {
    return {
        name: 'hot-file',
        configureServer(server) {
            const protocol = server.config.server?.https ? 'https' : 'http';
            const host = server.config.server?.host || 'localhost';
            const port = server.config.server?.port || 3000;
            const hotUrl = `${protocol}://${host}:${port}`;
            const hotFilePath = resolve(__dirname, 'public/hot');

            writeFileSync(hotFilePath, hotUrl);
            console.log(`Hot file created: ${hotFilePath} -> ${hotUrl}`);

            const cleanup = () => {
                if (existsSync(hotFilePath)) {
                    unlinkSync(hotFilePath);
                    console.log('Hot file cleaned up');
                }
            };

            process.on('SIGTERM', cleanup);
            process.on('SIGINT', cleanup);
            process.on('exit', cleanup);
        }
    };
}

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
                port: 3000,
            },
            watch: {
                usePolling: true,
                interval: 100,
                include: [
                    'app/Views/**/*.php',
                    'app/Views/**/*.blade.php',
                    '**/*.html'
                ],
                ignored: [
                    '**/node_modules/**',
                    '**/vendor/**',
                    '**/public/build/**'
                ]
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
        plugins: [
            hotFilePlugin(),
        ],
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