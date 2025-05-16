import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // File JS yang kamu gunakan
                'resources/css/app.css', 
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1', // Gunakan 127.0.0.1 agar sesuai dengan Laravel
        port: 5173,        // Port default Vite
    },
});