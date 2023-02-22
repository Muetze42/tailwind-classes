import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build : {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    return 'backdrop-brightness.css';
                },
            },
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css'],
            refresh: true,
        }),
    ],
});
