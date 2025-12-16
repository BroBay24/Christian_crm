<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Project Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                    <form action="{{ route('projects.store') }}" method="POST" onkeydown="return event.key != 'Enter';">
                        @csrf

                        <div class="mb-4">
                            <label for="lead_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Pilih Lead (Approved) <span class="text-red-500">*</span>
                            </label>
                            <select name="lead_id" id="lead_id" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('lead_id') border-red-500 @enderror"
                                    required>
                                <option value="">-- Pilih Lead --</option>
                                @foreach ($leads as $lead)
                                    <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->name }} - {{ $lead->company ?? 'No Company' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lead_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-600 text-xs italic mt-1">
                                Hanya lead dengan status "Approved" yang bisa dibuat project.
                            </p>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" 
                                    class=" text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat Project
                            </button>
                            <a href="{{ route('projects.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
