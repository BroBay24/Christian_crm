<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Lead') }}
            </h2>
            <a href="{{ route('leads.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                + Tambah Lead
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Alert Success --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Perusahaan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Telepon
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dibuat Oleh
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($leads as $index => $lead)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $leads->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lead->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lead->company ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lead->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lead->phone }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($lead->status === 'new')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    New
                                                </span>
                                            @elseif ($lead->status === 'approved')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Approved
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Rejected
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $lead->creator->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- Sales hanya bisa edit lead milik sendiri --}}
                                            @if (auth()->user()->isSales())
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('leads.edit', $lead) }}" 
                                                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold py-1 px-3 rounded shadow">
                                                        Edit
                                                    </a>
                                                    <a href="{{ route('leads.create') }}" 
                                                       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded shadow">
                                                        + Tambah Baru
                                                    </a>
                                                </div>
                                            @endif

                                            {{-- Manager bisa approve/reject dan hapus --}}
                                            @if (auth()->user()->isManager())
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('leads.edit', $lead) }}" 
                                                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold py-1 px-3 rounded shadow">
                                                        Edit
                                                    </a>

                                                    @if ($lead->status === 'new')
                                                        <form action="{{ route('leads.approve', $lead) }}" 
                                                              method="POST" 
                                                              class="inline-block">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded shadow"
                                                                    onclick="return confirm('Approve lead ini?')">
                                                                Approve
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('leads.reject', $lead) }}" 
                                                              method="POST" 
                                                              class="inline-block">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded shadow"
                                                                    onclick="return confirm('Reject lead ini?')">
                                                                Reject
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <form action="{{ route('leads.destroy', $lead) }}" 
                                                          method="POST" 
                                                          class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="bg-red-600  text-white font-semibold py-1 px-3 rounded shadow"
                                                                onclick="return confirm('Yakin hapus lead ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data lead.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $leads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
