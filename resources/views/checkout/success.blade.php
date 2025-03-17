<x-app-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Ödeme Başarılı!</h2>
                <p class="mt-2 text-gray-600">Siparişiniz başarıyla alındı. Sipariş numaranız: {{ $order->id }}</p>
                
                <div class="mt-8 max-w-2xl mx-auto">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Sipariş Detayları</h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-medium">{{ $item->product->name }}</span>
                                        <span class="text-gray-500 block text-sm">Adet: {{ $item->quantity }}</span>
                                    </div>
                                    <span class="font-medium">{{ number_format($item->price * $item->quantity, 2) }} ₺</span>
                                </div>
                            @endforeach
                            
                            <div class="pt-4 border-t border-gray-200">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ara Toplam</span>
                                    <span class="font-medium">{{ number_format($order->subtotal, 2) }} ₺</span>
                                </div>
                                <div class="flex justify-between mt-2">
                                    <span class="text-gray-600">KDV (%18)</span>
                                    <span class="font-medium">{{ number_format($order->tax, 2) }} ₺</span>
                                </div>
                                <div class="flex justify-between mt-2 text-lg font-bold">
                                    <span>Toplam</span>
                                    <span>{{ number_format($order->total, 2) }} ₺</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Teslimat Bilgileri</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-gray-600">Ad Soyad</span>
                                <span class="font-medium">{{ $order->first_name }} {{ $order->last_name }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-600">E-posta</span>
                                <span class="font-medium">{{ $order->email }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-600">Telefon</span>
                                <span class="font-medium">{{ $order->phone }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-600">Adres</span>
                                <span class="font-medium">{{ $order->address }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-600">Şehir</span>
                                <span class="font-medium">{{ $order->city }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-600">Posta Kodu</span>
                                <span class="font-medium">{{ $order->postal_code }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Alışverişe Devam Et
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 