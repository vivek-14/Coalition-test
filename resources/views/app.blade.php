<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0"
    />
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    @inertiaHead
</head>

<body class='flex justify-center bg-slate-950/80 py-6 text-white'>
    @inertia
</body>

</html>
