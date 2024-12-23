import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.jsx',  // For your JavaScript entry
                'resources/scss/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',   
                  // For your SCSS entry
            ],
            refresh: true,
        }),
    ],
});
