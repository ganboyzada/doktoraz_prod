import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    base: '',
    plugins: [
        laravel({
            input: [
                'resources/js/admin.js',
                'resources/js/app.js',
                'resources/scss/admin.scss',
                'resources/scss/app.scss',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: true,
        hmr: {
            host: '192.168.100.124',
            host: '192.168.1.124',
            protocol: 'ws',
        },
    },
});
