import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server:{
        // host: true,
        hmr:{
            host: 'localhost',
        },
    },
    // build: {
    //     outDir: 'public/build', // This is optional, depending on your needs
    //     rollupOptions: {
    //         input: {
    //             manifest: 'public/manifest.json',
    //             serviceworker: 'public/serviceworker.js'
    //         }
    //     }
    // }

    
});
