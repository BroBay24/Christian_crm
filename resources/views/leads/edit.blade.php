<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lead') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('leads.update', $lead) }}" method="POST" onkeydown="return event.key != 'Enter';">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nama <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $lead->name) }}"
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
                                   value="{{ old('company', $lead->company) }}"
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
                                   value="{{ old('email', $lead->email) }}"
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
                                   value="{{ old('phone', $lead->phone) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('phone') border-red-500 @enderror"
                                   required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status (Hanya Manager yang bisa ubah) --}}
                        @if (auth()->user()->isManager())
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700">
                                    Status
                                </label>
                                <select name="status" 
                                        id="status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="approved" {{ $lead->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $lead->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        @else
                            {{-- Sales hanya bisa lihat status --}}
                            <div class="mb-4 bg-gray-50 border border-gray-200 rounded p-3">
                                <p class="text-sm text-gray-700">
                                    <strong>Status saat ini:</strong> 
                                    @if ($lead->status === 'new')
                                        <span class="text-blue-600 font-semibold">New</span>
                                    @elseif ($lead->status === 'approved')
                                        <span class="text-green-600 font-semibold">Approved</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Rejected</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    (Hanya Manager yang dapat mengubah status)
                                </p>
                            </div>
                        @endif

                        {{-- Info pembuat --}}
                        <div class="mb-4 bg-blue-50 border border-blue-200 rounded p-3">
                            <p class="text-sm text-blue-800">
                                <strong>Dibuat oleh:</strong> {{ $lead->creator->name }} 
                                <span class="text-xs">({{ $lead->created_at->format('d M Y H:i') }})</span>
                            </p>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('leads.index') }}" 
                               class="inline-flex items-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded transition duration-150">
                                
                                Batal
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-black font-bold py-3 px-6 rounded transition duration-150 shadow-lg hover:shadow-xl">
                                
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
