<x-app-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Ürünler</h2>
                <div class="flex space-x-4">
                    <form action="{{ route('products.index') }}" method="GET" class="flex space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ürün ara..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <select name="sort" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Sıralama</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Fiyat (Düşükten Yükseğe)</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Fiyat (Yüksekten Düşüğe)</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>En Yeni</option>
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Filtrele
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        @if($product->getFirstMediaUrl())
                            <img src="{{ $product->getFirstMediaUrl() }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">
                                <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-2 line-clamp-2">{{ $product->description }}</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($product->sale_price)
                                        <span class="text-lg font-bold text-red-600">{{ number_format($product->sale_price, 2) }} ₺</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">{{ number_format($product->price, 2) }} ₺</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 2) }} ₺</span>
                                    @endif
                                </div>
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                        Sepete Ekle
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 