<x-app-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    @if($product->getFirstMediaUrl())
                        <img src="{{ $product->getFirstMediaUrl() }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-lg">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                    <div class="mb-6">
                        @if($product->sale_price)
                            <span class="text-2xl font-bold text-red-600">{{ number_format($product->sale_price, 2) }} ₺</span>
                            <span class="text-xl text-gray-500 line-through ml-2">{{ number_format($product->price, 2) }} ₺</span>
                        @else
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($product->price, 2) }} ₺</span>
                        @endif
                    </div>
                    <div class="prose max-w-none mb-6">
                        {{ $product->description }}
                    </div>
                    <div class="mb-6">
                        <span class="text-sm text-gray-500">Stok Durumu:</span>
                        @if($product->stock > 0)
                            <span class="text-green-600 font-semibold">Stokta ({{ $product->stock }} adet)</span>
                        @else
                            <span class="text-red-600 font-semibold">Stokta Yok</span>
                        @endif
                    </div>
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="flex items-center space-x-4">
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">Adet</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700">
                                    Sepete Ekle
                                </button>
                            </div>
                        </form>
                    @endif
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold mb-2">Kategoriler:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->categories as $category)
                                <a href="{{ route('categories.show', $category) }}" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full hover:bg-gray-200">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @if($relatedProducts->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold mb-6">Benzer Ürünler</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                @if($relatedProduct->getFirstMediaUrl())
                                    <img src="{{ $relatedProduct->getFirstMediaUrl() }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold mb-2">
                                        <a href="{{ route('products.show', $relatedProduct) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $relatedProduct->name }}
                                        </a>
                                    </h3>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if($relatedProduct->sale_price)
                                                <span class="text-lg font-bold text-red-600">{{ number_format($relatedProduct->sale_price, 2) }} ₺</span>
                                                <span class="text-sm text-gray-500 line-through ml-2">{{ number_format($relatedProduct->price, 2) }} ₺</span>
                                            @else
                                                <span class="text-lg font-bold text-gray-900">{{ number_format($relatedProduct->price, 2) }} ₺</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 