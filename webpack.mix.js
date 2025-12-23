const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")

    // Tailwind ТОЛЬКО для Breeze
    .postCss("resources/css/app.css", "public/css/tailwind.css", [
        require("tailwindcss"),
        require("autoprefixer"),
    ])

    // СТАРЫЙ ДИЗАЙН
    .sass("resources/scss/app.scss", "public/css/app.css")

    .version();
