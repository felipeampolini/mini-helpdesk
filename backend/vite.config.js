import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0', // permite acesso externo (de fora do container)
        port: 5173,       // porta do Vite
        strictPort: true,
        cors: {
            origin: 'http://localhost:8000',
            credentials: true,
        },
        hmr: {
            host: 'localhost',
            port: 5173,
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
