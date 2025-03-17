<x-app-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-4">Kategoriler</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($categories as $category)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('categories.show', $category) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ $category->name }}
                            </a>
                        </h3>
                        @if($category->description)
                            <p class="text-gray-600 mb-2">{{ $category->description }}</p>
                        @endif
                        @if($category->children->count() > 0)
                            <div class="mt-2">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Alt Kategoriler:</h4>
                                <ul class="list-disc list-inside">
                                    @foreach($category->children as $child)
                                        <li>
                                            <a href="{{ route('categories.show', $child) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout> 