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
});
/*
export default defineConfig({
    plugins: [
        laravel({
            input: {
                'resources/js/app.js': '/js/app.js' // Ruta de entrada para tu archivo JS principal
            },
            css: {
                extract: 'public/css/app.css', // Ruta de salida para tu archivo CSS compilado
                exclude: ['dataTables.bootstrap4.min.css','dataTables.bootstrap4.min.css','select2.css','sweetalert2.min.css','pace-theme-center-radar.min.css'], // Excluir el archivo CSS específico de la compilación
            },
            js: {
                extract: 'public/css/app.js', // Ruta de salida para tu archivo JS compilado
                exclude: ['jquery.dataTables.min.js','dataTables.bootstrap4.min.js','select2.min.js','Chart.bundle.min.js','sweetalert2.all.min.js','pace.min.js'], // Excluir el archivo CSS específico de la compilación
            },
            refresh: true,
        }),
    ],
});
*/