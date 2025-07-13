<nav class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Mobile menu button-->
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" 
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

            <!-- Logo and Desktop Navigation -->
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex flex-shrink-0 items-center">
                    <h1 class="text-xl font-bold text-blue-600">PLN Pascabayar</h1>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600' }}">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    @if(auth()->user()->level->nama_level === 'Admin')
                    <a href="{{ route('tarif.index') }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('tarif.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600' }}">
                        <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                        </svg>
                        Tarif
                    </a>
                    @endif

                    <a href="{{ route('pelanggan.index') }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-600' }}">
                        <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        Pelanggan
                    </a>
                </div>
            </div>

            <!-- User Menu -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:pr-0">
                <div class="relative ml-3">
                    <div class="flex items-center">
                        <span class="hidden sm:block mr-3 text-sm text-gray-700">{{ auth()->user()->nama_admin }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="hidden sm:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <a href="{{ route('dashboard') }}"
                class="block rounded-md px-3 py-2 text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Dashboard
            </a>

            @if(auth()->user()->level->nama_level === 'Admin')
            <a href="{{ route('tarif.index') }}"
                class="block rounded-md px-3 py-2 text-base font-medium {{ request()->routeIs('tarif.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Tarif
            </a>
            @endif

            <a href="{{ route('pelanggan.index') }}"
                class="block rounded-md px-3 py-2 text-base font-medium {{ request()->routeIs('pelanggan.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Pelanggan
            </a>

            <div class="border-t border-gray-200 pt-4">
                <div class="px-3 text-sm text-gray-700">{{ auth()->user()->nama_admin }}</div>
            </div>
        </div>
    </div>
</nav>
