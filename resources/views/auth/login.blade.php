<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'PLN Pascabayar') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="min-h-screen bg-yellow-500/50">
    <div class="flex min-h-screen items-center justify-center p-6">
      <div class="relative w-full max-w-md space-y-8 overflow-hidden rounded-2xl bg-white p-8 shadow-xl">
        <!-- Decorative Elements -->
        <div class="absolute left-0 top-0 h-2 w-full bg-blue-600"></div>
        <div class="absolute right-4 top-2 text-blue-600">
          <svg class="h-16 w-16 opacity-10" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M11.5 3.364L10.086 4.78L11.5 6.194L12.914 4.78L11.5 3.364ZM20.315 12.179L18.901 13.593L20.315 15.007L21.729 13.593L20.315 12.179ZM2.685 12.179L1.271 13.593L2.685 15.007L4.099 13.593L2.685 12.179ZM11.5 18.364L10.086 19.78L11.5 21.194L12.914 19.78L11.5 18.364ZM14.986 7.222L13.572 8.636L14.986 10.05L16.4 8.636L14.986 7.222ZM8.014 7.222L6.6 8.636L8.014 10.05L9.428 8.636L8.014 7.222ZM14.986 15.222L13.572 16.636L14.986 18.05L16.4 16.636L14.986 15.222ZM8.014 15.222L6.6 16.636L8.014 18.05L9.428 16.636L8.014 15.222Z" />
          </svg>
        </div>

        <!-- Login Form -->
        <div class="text-center">
          <h2 class="text-3xl font-bold text-gray-900">Selamat Datang</h2>
          <p class="mt-2 text-sm text-gray-600">Sistem Pembayaran Listrik Pascabayar</p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
          @csrf

          @if ($errors->any())
            <div class="rounded-lg bg-red-50 p-4 text-sm text-red-500">
              <ul class="list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="space-y-4">
            <div>
              <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
              <div class="relative mt-1">
                <input id="username" name="username" type="text" required
                  class="block w-full appearance-none rounded-lg border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
              </div>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <div class="relative mt-1">
                <input id="password" name="password" type="password" required
                  class="block w-full appearance-none rounded-lg border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
              </div>
            </div>
          </div>

          <button type="submit"
            class="flex w-full justify-center rounded-lg border border-transparent bg-blue-600 px-4 py-3 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            Masuk
          </button>
        </form>
      </div>
    </div>
  </body>

</html>
