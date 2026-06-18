import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // TAMBAHKAN BAGIAN DI BAWAH INI
    build: {
        rollupOptions: {
            output: {
                // Mengunci nama file agar selalu menjadi app.js dan app.css tetap
                entryFileNames: 'assets/app.js',
                chunkFileNames: 'assets/app.js',
                assetFileNames: 'assets/app.[ext]'
            }
        }
    }
});