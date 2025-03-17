<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('products.index') }}" class="text-xl font-bold text-gray-800">{{ config('app.name') }}</a>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Kategoriler</a>
                            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Ürünler</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                            Sepet
                            @if(session()->has('cart_session_id'))
                                <span class="ml-1 bg-red-500 text-white px-2 py-1 rounded-full text-xs">
                                    {{ App\Models\Cart::where('session_id', session('cart_session_id'))->first()?->items->count() ?? 0 }}
                                </span>
                            @endif
                        </a>
                        @auth
                            <div class="ml-3 relative">
                                <div>
                                    <button type="button" class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button">
                                        <span class="sr-only">Kullanıcı menüsü</span>
                                        <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Giriş Yap</a>
                            <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Kayıt Ol</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>