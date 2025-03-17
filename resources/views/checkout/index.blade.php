<x-app-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-6">Ödeme</h2>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Teslimat Bilgileri</h3>
                        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">Ad</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', auth()->user()->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Soyad</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">E-posta</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefon</label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Adres</label>
                                    <textarea name="address" id="address" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address') }}</textarea>
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">Şehir</label>
                                    <input type="text" name="city" id="city" value="{{ old('city') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Posta Kodu</label>
                                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="mt-8">
                                <h3 class="text-lg font-semibold mb-4">Kart Bilgileri</h3>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label for="card_holder" class="block text-sm font-medium text-gray-700">Kart Üzerindeki İsim</label>
                                        <input type="text" name="card_holder" id="card_holder" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="card_number" class="block text-sm font-medium text-gray-700">Kart Numarası</label>
                                        <input type="text" name="card_number" id="card_number" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <label for="expiry" class="block text-sm font-medium text-gray-700">Son Kullanma Tarihi (AA/YY)</label>
                                            <input type="text" name="expiry" id="expiry" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                            <input type="text" name="cvv" id="cvv" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Sipariş Özeti</h3>
                        <div class="space-y-4">
                            @foreach($cart->items as $item)
                                <div class="flex justify-between">
                                    <div>
                                        <span class="font-medium">{{ $item->product->name }}</span>
                                        <span class="text-gray-500 block text-sm">Adet: {{ $item->quantity }}</span>
                                    </div>
                                    <span class="font-medium">
                                        @if($item->product->sale_price)
                                            {{ number_format($item->product->sale_price * $item->quantity, 2) }} ₺
                                        @else
                                            {{ number_format($item->product->price * $item->quantity, 2) }} ₺
                                        @endif
                                    </span>
                                </div>
                            @endforeach

                            <div class="pt-4 border-t border-gray-200">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ara Toplam</span>
                                    <span class="font-medium">{{ number_format($cart->getTotalAttribute(), 2) }} ₺</span>
                                </div>
                                <div class="flex justify-between mt-2">
                                    <span class="text-gray-600">KDV (%18)</span>
                                    <span class="font-medium">{{ number_format($cart->getTotalAttribute() * 0.18, 2) }} ₺</span>
                                </div>
                                <div class="flex justify-between mt-2 text-lg font-bold">
                                    <span>Toplam</span>
                                    <span>{{ number_format($cart->getTotalAttribute() * 1.18, 2) }} ₺</span>
                                </div>
                            </div>

                            <button type="submit" form="checkout-form" class="w-full mt-6 bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700">
                                Ödemeyi Tamamla
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 