import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/navbar.js',
                'resources/js/responsivedashboard.js',
                'resources/css/menu.css',
                'resources/js/menu.js',
                'resources/js/responsiveadduser.js',
                'resources/js/responsiveedituser.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
