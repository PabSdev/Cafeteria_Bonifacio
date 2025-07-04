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
                'resources/js/product/responsiveaddproduct.js',
                'resources/css/menu.css',
                'resources/js/menu/menu.js',
                'resources/js/shopping/cart.js',
                'resources/css/shopping.css',
                'resources/js/shopping/filter.js',
                'resources/js/orders.js',
                'resources/js/responsiveeditproduct.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
     build: {
        // Esto asegura que los archivos de audio se copien a la carpeta pública
        assetsInlineLimit: 0,
    },
})
