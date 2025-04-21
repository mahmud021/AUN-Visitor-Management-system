import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
    plugins: [
        laravel([
            "resources/css/app.css",
            "resources/js/app.js",
            "node_modules/apexcharts/dist/apexcharts.css",
            "node_modules/preline/dist/helper-apexcharts.js",
        ]),

        // viteStaticCopy({
        //     targets: [
        //         {
        //             // UI bundle
        //             src: 'node_modules/scanbot-web-sdk/bundle/ScanbotSDK.ui2.min.js',
        //             dest: '../vendor/scanbot'          // <-- note "../"
        //         },
        //         {
        //             // WASM + workers (copy the whole dir)
        //             src: 'node_modules/scanbot-web-sdk/bundle/bin/complete/**/*',
        //             dest: '../vendor/scanbot/bin/complete'
        //         }
        //     ]
        // })
    ],
});
