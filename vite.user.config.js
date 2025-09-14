import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/assets/user/main.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@user': path.resolve(__dirname, 'resources/assets/user'),
        },
    },
    server: {
        port: 5175, // FE user
    },
})