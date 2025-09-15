// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import fs from 'fs';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5174, // Use the port that's actually available
        https: {
            key: fs.readFileSync('./shopify.local.key'),
            cert: fs.readFileSync('./shopify.local.crt'),
        },
        hmr: {
            host: 'shopify.local',
            port: 5174, // Match this port
        },
        cors: {
            origin: ['https://shopify.local', 'https://shopify.local:443'],
            credentials: true,
        },
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
