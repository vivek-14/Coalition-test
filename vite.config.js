import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vuePlugin from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
    resolve: {
        alias: [
            {
                find: "@",
                replacement: path.resolve(__dirname, "./resources/js"),
            },
            {
                find: "@components",
                replacement: path.resolve(
                    __dirname,
                    "./resources/js/Components"
                ),
            },
            {
                find: "@pages",
                replacement: path.resolve(__dirname, "./resources/js/Pages"),
            },
        ],
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vuePlugin(),
    ],
});
