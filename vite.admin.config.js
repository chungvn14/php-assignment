import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/assets/admin/main.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@admin': path.resolve(__dirname, 'resources/assets/admin'),
        },
    },
    server: {
        port: 5173, // FE admin
    },
})