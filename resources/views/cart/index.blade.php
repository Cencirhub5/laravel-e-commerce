<x-app-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-6">Alışveriş Sepeti</h2>

            @if($cart->items->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-8">
                        <div class="space-y-4">
                            @foreach($cart->items as $item)
                                <div class="flex items-center space-x-4 bg-white p-4 rounded-lg shadow">
                                    <div class="flex-shrink-0 w-24 h-24">
                                        @if($item->product->getFirstMediaUrl())
                                            <img src="{{ $item->product->getFirstMediaUrl() }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold">
                                            <a href="{{ route('products.show', $item->product) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                        <div class="mt-1">
                                            @if($item->product->sale_price)
                                                <span class="text-lg font-bold text-red-600">{{ number_format($item->product->sale_price, 2) }} ₺</span>
                                                <span class="text-sm text-gray-500 line-through ml-2">{{ number_format($item->product->price, 2) }} ₺</span>
                                            @else
                                                <span class="text-lg font-bold text-gray-900">{{ number_format($item->product->price, 2) }} ₺</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <form action="{{ route('cart.update', $item->product) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="submit" class="ml-2 text-indigo-600 hover:text-indigo-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="lg:col-span-4">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Sipariş Özeti</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ara Toplam</span>
                                    <span class="font-semibold">{{ number_format($cart->getTotalAttribute(), 2) }} ₺</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">KDV (%18)</span>
                                    <span class="font-semibold">{{ number_format($cart->getTotalAttribute() * 0.18, 2) }} ₺</span>
                                </div>
                                <div class="pt-2 border-t border-gray-200">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-bold">Toplam</span>
                                        <span class="text-lg font-bold">{{ number_format($cart->getTotalAttribute() * 1.18, 2) }} ₺</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('checkout.index') }}" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 flex items-center justify-center">
                                    Ödemeye Geç
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Sepetiniz boş</h3>
                    <p class="mt-1 text-gray-500">Alışverişe başlamak için ürünleri incelemeye ne dersiniz?</p>
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Ürünleri İncele
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 