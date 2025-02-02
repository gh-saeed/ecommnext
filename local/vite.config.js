import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/admin.scss','resources/sass/seller.scss','resources/sass/home.scss'],
            refresh: true,
        }),
    ],
});
