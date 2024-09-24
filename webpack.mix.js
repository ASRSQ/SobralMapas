const mix = require("laravel-mix");

// Compilando e minificando app.js e map.js
mix.js("resources/js/app.js", "public/js")
    .js("resources/js/map.js", "public/js")
    .minify("public/js/app.js") // Minifica o arquivo app.js final
    .minify("public/js/map.js"); // Minifica o arquivo map.js final

// Compilando e minificando custom.css
mix.postCss("resources/css/custom.css", "public/css").minify(
    "public/css/custom.css"
); // Minifica o arquivo CSS final

mix.browserSync({
    proxy: "http://127.0.0.1:8000",
    files: [
        "app/**/*.php",
        "resources/views/**/*.php",
        "resources/js/**/*.js", // Alteração: usaremos ** para monitorar recursivamente
        "resources/css/**/*.css", // Alteração: usaremos ** para monitorar recursivamente
        "routes/**/*.php",
        "public/js/*.js", // Certifica-se de que ele monitore também a pasta de saída em public
        "public/css/*.css", // Certifica-se de que ele monitore também a pasta de saída em public
    ],
    open: false,
    notify: false,
    reloadDelay: 200,
    watchOptions: {
        usePolling: true,
        interval: 1000,
    },
    cache: false,
});
