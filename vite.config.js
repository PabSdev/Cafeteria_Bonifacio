import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/responsiveadduser.js',
                'resources/js/responsivedashboard.js',
                'resources/js/responsiveedituser.js',
                'resources/js/navbar.js',
                'resources/js/responsiveaddproduct.js',
                'resources/css/menu.css',
                'resources/js/menu.js',
                "resources/js/shopping.js",
                'resources/css/shopping.css'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
})
