<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Lead Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('leads.store') }}" method="POST" onkeydown="return event.key != 'Enter';">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nama <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Perusahaan --}}
                        <div class="mb-4">
                            <label for="company" class="block text-sm font-medium text-gray-700">
                                Perusahaan
                            </label>
                            <input type="text" 
                                   name="company" 
                                   id="company" 
                                   value="{{ old('company') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('company')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Telepon --}}
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('phone') border-red-500 @enderror"
                                   required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info: created_by otomatis diisi --}}
                        <div class="mb-4 bg-blue-50 border border-blue-200 rounded p-3">
                            <p class="text-sm text-blue-800">
                                <strong>Info:</strong> Lead ini akan tercatat atas nama: <strong>{{ auth()->user()->name }}</strong>
                            </p>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('leads.index') }}" 
                               class="inline-flex items-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded transition duration-150">
                                
                                Batal
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center bg-green-500 hover:bg-green-700 text-black font-bold py-3 px-6 rounded transition duration-150 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Simpan Lead Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
