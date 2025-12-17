<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign Produk ke Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Customer Info --}}
                    <div class="mb-6 p-4 bg-gray-50 rounded">
                        <h3 class="font-semibold mb-2">Customer:</h3>
                        <p class="text-lg">{{ $customer->lead->name }} - {{ $customer->lead->company ?? 'No Company' }}</p>
                    </div>

                    {{-- Alert Errors --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">Ada masalah dengan input Anda.</span>
                            <ul class="mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($products->count() > 0)
                        <form action="{{ route('customers.products.store', $customer) }}" method="POST" onkeydown="return event.key != 'Enter';">
                            @csrf

                            <div class="mb-4">
                                <label for="product_id" class="block text-gray-700 text-sm font-bold mb-2">
                                    Pilih Produk <span class="text-red-500">*</span>
                                </label>
                                <select name="product_id" id="product_id" 
                                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('product_id') border-red-500 @enderror"
                                        required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} - {{ $product->speed ?? 'N/A' }} - Rp {{ number_format($product->price, 0, ',', '.') }}/bulan
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">
                                    Tanggal Mulai Langganan <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="start_date" 
                                       id="start_date" 
                                       value="{{ old('start_date', date('Y-m-d')) }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('start_date') border-red-500 @enderror"
                                       required>
                                @error('start_date')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">
                                    Tanggal Berakhir (Opsional)
                                </label>
                                <input type="date" 
                                       name="end_date" 
                                       id="end_date" 
                                       value="{{ old('end_date') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('end_date') border-red-500 @enderror">
                                @error('end_date')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-600 text-xs italic mt-1">
                                    Kosongkan jika langganan masih aktif tanpa batas waktu.
                                </p>
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-Black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Assign Produk
                                </button>
                                <a href="{{ route('customers.show', $customer) }}" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Batal
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Semua produk sudah di-assign ke customer ini.</p>
                            <a href="{{ route('customers.show', $customer) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
