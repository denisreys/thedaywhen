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
                description: "remember every day",
                display: "standalone",
                theme_color: "#8c819c",
                background_color: "#C1B2D9",
                icons: [
                    {
                        src: "/images/short_logo_512x512.jpg",
                        sizes: "512x512",
                        type: "image/jpg"
                    },
                    {
                        src: "/images/short_logo_384x384.jpg",
                        sizes: "384x384",
                        type: "image/jpg"
                    },
                    {
                        src: "/images/short_logo_192x192.jpg",
                        sizes: "192x192",
                        type: "image/jpg"
                    },
                    {
                        src: "/images/short_logo_152x152.jpg",
                        sizes: "152x152",
                        type: "image/jpg"
                    },
                    {
                        src: "/images/short_logo_180x180.jpg",
                        sizes: "180x180",
                        type: "image/jpg"
                    },
                    {
                        src: "/images/short_logo_144x144.jpg",
                        sizes: "144x144",
                        type: "image/jpg"
                    },
                    {
                        src: "/images/short_logo_128x128.jpg",
                        sizes: "128x128",
                        type: "image/jpg"
                    },
                    {
                        src: "/images/short_logo_120x120.jpg",
                        sizes: "120x120",
                        type: "image/jpg"
                    },
                    {
                        src: "/images/short_logo_72x72.jpg",
                        sizes: "72x72",
                        type: "image/jpg"
                    },
                ]
            }
        }),
        
    ],
});
