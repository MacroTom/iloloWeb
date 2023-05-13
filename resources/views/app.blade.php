<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @if (config("app.env") !== "local")
        <link rel="stylesheet" href="/build/{{getAssets()['css']}}">
        <script src="/build/{{getAssets()['js']}}" type="module"></script>
    @else
        @vite('resources/js/app.js')
    @endif
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>
