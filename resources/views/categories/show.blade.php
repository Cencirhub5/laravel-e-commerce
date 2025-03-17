<x-app-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-2">{{ $category->name }}</h2>
                @if($category->description)
                    <p class="text-gray-600">{{ $category->description }}</p>
                @endif
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