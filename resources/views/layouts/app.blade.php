<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <main class="max-w-2xl mx-auto px-4 py-24">
        <div class="mb-8">
            <h1 class="text-3xl text-center uppercase font-bold text-amber-600">
                {{ config('app.name') }}
            </h1>
            <p class="text-sm text-center">Laravel Task Management App</p>
        </div>

        @yield('content')

    </main>
    
    @yield('scripts')
</body>
</html>