<!DOCTYPE html>
<html>

<head>
    <title>PT. Techno Triireka</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @php
        $isProduction = env('APP_ENV') === 'production';
        $manifestPath = $isProduction ? 'build/manifest.json' : public_path('build/manifest.json');
    @endphp

    @if ($isProduction && file_exists($manifestPath))
        @php
            $manifest = json_decode(file_get_contents($manifestPath), true);
        @endphp
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vuetify@3.7.0-beta.1/dist/vuetify.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css" />

        <link rel="stylesheet" href="/build/{{ $manifest['resources/css/app.css']['file'] }}">
        <link rel="stylesheet" href="/build/{{ $manifest['resources/scss/variables.scss']['file'] }}">
        <script type="module" src="/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
    @else
        @vite([
            'resources/css/app.css',
            'resources/scss/variables.scss',
            'resources/js/app.js'
        ])
    @endif
</head>

<body>
    <div id="app"></div>
</body>

</html>