import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss',
                'resources/sass/pages/dashboard.scss',
                'resources/js/pages/dashboard.js',
            ],
            refresh: true,
        }),
    ],
});
