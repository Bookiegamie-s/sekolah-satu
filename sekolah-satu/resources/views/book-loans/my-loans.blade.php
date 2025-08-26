@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Peminjaman Buku Saya</h1>
                    <p class="text-gray-600 mt-1">{{ auth()->user()->name }}</p>
                </div>
                <div class="text-right">
                    <div class="bg-blue-100 rounded-lg p-3">
                        <i class="fas fa-book-reader text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-blue-500 rounded-full p-3">
                                <i class="fas fa-book text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Peminjaman</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $loans->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-yellow-500 rounded-full p-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Sedang Dipinjam</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $loans->where('status', 'borrowed')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-green-500 rounded-full p-3">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Sudah Dikembalikan</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $loans->where('status', 'returned')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-red-500 rounded-full p-3">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Terlambat</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $loans->where('status', 'overdue')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($loans->count() > 0)
            <!-- Book Loans Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Riwayat Peminjaman</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Buku
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Pinjam
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jatuh Tempo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Kembali
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Denda
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loans as $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-book text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $loan->book->title }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $loan->book->author }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'borrowed' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Dipinjam'],
                                                'returned' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Dikembalikan'],
                                                'overdue' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Terlambat'],
                                            ];
                                            $config = $statusConfig[$loan->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'text' => ucfirst($loan->status)];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['class'] }}">
                                            {{ $config['text'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($loan->fine_amount > 0)
                                            <span class="text-red-600 font-semibold">
                                                Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-green-600">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($loans->hasPages())
                <div class="bg-gray-50 px-6 py-4">
                    {{ $loans->links() }}
                </div>
                @endif
            </div>
        @else
            <!-- No Loans -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-book-open text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Peminjaman</h3>
                <p class="text-gray-500 mb-4">Anda belum pernah meminjam buku. Mulai jelajahi katalog buku kami!</p>
                <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-book mr-2"></i>
                    Lihat Katalog Buku
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
