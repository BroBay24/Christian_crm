<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Customer') }}
            </h2>
            <a href="{{ route('customers.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Alert Success --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- 2 Column Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left Sidebar: Customer Info --}}
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-6 text-gray-800">Informasi Customer</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Nama</p>
                                    <p class="font-semibold text-gray-900">{{ $customer->lead->name }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Perusahaan</p>
                                    <p class="font-semibold text-gray-900">{{ $customer->lead->company ?? '-' }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Email</p>
                                    <p class="font-semibold text-gray-900">{{ $customer->lead->email }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Telepon</p>
                                    <p class="font-semibold text-gray-900">{{ $customer->lead->phone }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Tanggal Mulai</p>
                                    <p class="font-semibold text-gray-900">{{ $customer->start_date->format('d/m/Y') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Status</p>
                                    @if ($customer->status === 'active')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Content: Products Section --}}
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-black-800">Produk yang Dimiliki</h3>
                                <a href="{{ route('customers.products.create', $customer) }}" 
                                   class="bg-black-600 hover:bg-green-700 text-black font-semibold py-2 px-4 rounded shadow inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Assign Produk
                                </a>
                            </div>

                            @if ($customer->products->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kecepatan</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga/Bulan</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Mulai</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Berakhir</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($customer->products as $product)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                        {{ $product->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $product->speed ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ \Carbon\Carbon::parse($product->pivot->start_date)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $product->pivot->end_date ? \Carbon\Carbon::parse($product->pivot->end_date)->format('d/m/Y') : 'Aktif' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($product->pivot->status === 'active')
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                Active
                                                            </span>
                                                        @else
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                Inactive
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <form action="{{ route('customers.products.destroy', [$customer, $product]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded shadow"
                                                                    onclick="return confirm('Hapus produk ini dari customer?')">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-8">
                                    Belum ada produk. Assign produk pertama
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
