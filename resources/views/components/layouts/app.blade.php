<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}" data-theme="business">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Zonelist - Amazone Bestsellers</title>

        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>

    <body>
        {{ $slot }}
    </body>
</html>
