<x-app-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Ödeme Başarısız!</h2>
                <p class="mt-2 text-gray-600">{{ $error }}</p>
                
                <div class="mt-8">
                    <a href="{{ route('checkout.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Tekrar Dene
                    </a>
                    <a href="{{ route('cart.index') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Sepete Dön
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 