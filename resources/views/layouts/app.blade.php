<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'PLN Pascabayar') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="font-inter h-full antialiased">
    <div class="min-h-screen bg-gray-50">
      @include('components.navbar')

      <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        @include('components.alerts')

        @yield('main')
      </main>

      @include('components.footer')
    </div>

    @stack('scripts')
  </body>

</html>
