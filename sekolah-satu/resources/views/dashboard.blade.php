<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Dashboard") }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Message -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Selamat datang, {{ auth()->user()->name }}!
                </h3>
                <p class="text-gray-600">
                    Anda login sebagai: <span class="font-semibold">{{ auth()->user()->getRoleNames()->first() }}</span>
                </p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Students -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $data["total_students"] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Teachers -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Guru</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $data["total_teachers"] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Classes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Kelas</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $data["total_classes"] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Books -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Buku</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $data["total_books"] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Library Statistics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Borrowed Books -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Buku Dipinjam</h4>
                    <p class="text-3xl font-bold text-blue-600">{{ $data["borrowed_books"] }}</p>
                    <p class="text-sm text-gray-500">Buku sedang dipinjam</p>
                </div>
            </div>

            <!-- Overdue Books -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Buku Terlambat</h4>
                    <p class="text-3xl font-bold text-red-600">{{ $data["overdue_books"] }}</p>
                    <p class="text-sm text-gray-500">Buku melewati batas waktu</p>
                </div>
            </div>

            <!-- Total Fines -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Total Denda</h4>
                    <p class="text-3xl font-bold text-yellow-600">Rp {{ number_format($data["total_fines"], 0, ",", ".") }}</p>
                    <p class="text-sm text-gray-500">Denda keterlambatan</p>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Loans -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Peminjaman Terbaru</h4>
                    <div class="space-y-3">
                        @forelse($data["recent_loans"] as $loan)
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $loan->book->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $loan->user->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-900">{{ $loan->loan_date->format("d/m/Y") }}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($loan->status === "borrowed") bg-blue-100 text-blue-800
                                        @elseif($loan->status === "returned") bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada peminjaman</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Overdue Loans -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Buku Terlambat</h4>
                    <div class="space-y-3">
                        @forelse($data["overdue_loans"] as $loan)
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $loan->book->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $loan->user->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-red-600">{{ $loan->due_date->format("d/m/Y") }}</p>
                                    <p class="text-xs text-red-500">
                                        {{ $loan->due_date->diffInDays(now()) }} hari terlambat
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada buku terlambat</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
