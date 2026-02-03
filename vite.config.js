// Node built-in modules
import { fileURLToPath, URL } from 'node:url';

// npm packages
import vue from '@vitejs/plugin-vue';
import { defineConfig } from 'vite';
import vueDevTools from 'vite-plugin-vue-devtools';

// own aliases / local imports

// https://vite.dev/config/
export default defineConfig({
    plugins: [
        vue(),
        ...(process.env.NODE_ENV === 'development' ? [vueDevTools()] : []),
    ],
    server: {
        host: 'dnx.test',
        port: 5173,
        origin: 'https://dnx.test',
        strictPort: true,
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources', import.meta.url)),
        },
    },
    build: {
        rollupOptions: {
            input: {
                portfolio: 'resources/js/portfolio/main.js',
                dashboard: 'resources/js/dashboard/main.js',
            },
        },
        manifest: "mix-manifest.json",
    },
});
