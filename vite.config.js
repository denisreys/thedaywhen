import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa'


export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                base: null,
                includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            manifest: {
                name: "thedaywhen",
                start_url: "/",
                scope: "/",
                short_name: "TDW",
                description: "remember every day",
                display: "standalone",
                theme_color: "#C1B2D9",
                background_color: "#C1B2D9",
            }
        }),
        
    ],
});
