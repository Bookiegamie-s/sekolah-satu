<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Perpustakaan - Data Buku") }}
            </h2>
            @can("create", App\Models\Book::class)
                <a href="{{ route("books.create") }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Buku
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search and Filter -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="GET" action="{{ route("books.index") }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-64">
                        <input type="text" 
                               name="search" 
                               value="{{ request("search") }}"
                               placeholder="Cari judul, penulis, atau ISBN..."
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <select name="category" class="rounded-md border-gray-300 shadow-sm">
                            <option value="">Semua Kategori</option>
                            <option value="fiction" @if(request("category") === "fiction") selected @endif>Fiksi</option>
                            <option value="non-fiction" @if(request("category") === "non-fiction") selected @endif>Non-Fiksi</option>
                            <option value="textbook" @if(request("category") === "textbook") selected @endif>Buku Pelajaran</option>
                            <option value="reference" @if(request("category") === "reference") selected @endif>Referensi</option>
                            <option value="biography" @if(request("category") === "biography") selected @endif>Biografi</option>
                            <option value="science" @if(request("category") === "science") selected @endif>Sains</option>
                            <option value="technology" @if(request("category") === "technology") selected @endif>Teknologi</option>
                            <option value="history" @if(request("category") === "history") selected @endif>Sejarah</option>
                            <option value="religion" @if(request("category") === "religion") selected @endif>Agama</option>
                            <option value="other" @if(request("category") === "other") selected @endif>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <select name="availability" class="rounded-md border-gray-300 shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="available" @if(request("availability") === "available") selected @endif>Tersedia</option>
                            <option value="borrowed" @if(request("availability") === "borrowed") selected @endif>Dipinjam</option>
                        </select>
                    </div>
                    <button type="submit" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cari
                    </button>
                    @if(request()->anyFilled(["search", "category", "availability"]))
                        <a href="{{ route("books.index") }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($books->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($books as $book)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                <!-- Book Cover -->
                                <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <div class="text-center p-4">
                                        <svg class="mx-auto h-12 w-12 text-blue-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                        </svg>
                                        <p class="text-xs text-blue-600 font-medium">{{ strtoupper($book->category) }}</p>
                                    </div>
                                </div>

                                <!-- Book Info -->
                                <div class="p-4">
                                    <h3 class="font-medium text-gray-900 text-sm mb-1 line-clamp-2">
                                        {{ $book->title }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $book->author }}</p>
                                    
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs text-gray-500">{{ $book->publication_year }}</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($book->available_copies > 0) bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            @if($book->available_copies > 0)
                                                {{ $book->available_copies }} tersedia
                                            @else
                                                Tidak tersedia
                                            @endif
                                        </span>
                                    </div>

                                    <div class="text-xs text-gray-500 mb-3">
                                        <p>ISBN: {{ $book->isbn }}</p>
                                        <p>Total: {{ $book->total_copies }} buku</p>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route("books.show", $book) }}" 
                                           class="flex-1 text-center bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-2 rounded text-xs font-medium">
                                            Detail
                                        </a>
                                        @can("update", $book)
                                            <a href="{{ route("books.edit", $book) }}" 
                                               class="flex-1 text-center bg-yellow-50 text-yellow-600 hover:bg-yellow-100 px-3 py-2 rounded text-xs font-medium">
                                                Edit
                                            </a>
                                        @endcan
                                    </div>

                                    @if($book->available_copies > 0)
                                        <div class="mt-2">
                                            <a href="{{ route("book-loans.create", ["book_id" => $book->id]) }}" 
                                               class="w-full block text-center bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-xs font-medium">
                                                Pinjam Buku
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $books->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada buku</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if(request()->anyFilled(["search", "category", "availability"]))
                                Tidak ada buku yang sesuai dengan kriteria pencarian.
                            @else
                                Mulai dengan menambahkan buku baru ke perpustakaan.
                            @endif
                        </p>
                        @can("create", App\Models\Book::class)
                            <div class="mt-6">
                                <a href="{{ route("books.create") }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Tambah Buku
                                </a>
                            </div>
                        @endcan
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Total Buku</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $totalBooks ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Tersedia</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $availableBooks ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Dipinjam</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $borrowedBooks ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Terlambat</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $overdueBooks ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>
