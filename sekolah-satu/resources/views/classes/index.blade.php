<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Data Kelas") }}
            </h2>
            @can("create", App\Models\SchoolClass::class)
                <a href="{{ route("classes.create") }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Kelas
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search and Filter -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="GET" action="{{ route("classes.index") }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-64">
                        <input type="text" 
                               name="search" 
                               value="{{ request("search") }}"
                               placeholder="Cari nama kelas..."
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <select name="grade" class="rounded-md border-gray-300 shadow-sm">
                            <option value="">Semua Tingkat</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" @if(request("grade") == $i) selected @endif>
                                    Kelas {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cari
                    </button>
                    @if(request()->anyFilled(["search", "grade"]))
                        <a href="{{ route("classes.index") }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Classes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($classes as $class)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <!-- Class Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $class->name }}</h3>
                                <p class="text-sm text-gray-500">Tingkat {{ $class->grade }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $class->academic_year }}
                                </span>
                            </div>
                        </div>

                        <!-- Class Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-blue-600">{{ $class->students_count ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Siswa</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-green-600">{{ $class->max_students }}</p>
                                <p class="text-xs text-gray-500">Kapasitas</p>
                            </div>
                        </div>

                        <!-- Homeroom Teacher -->
                        @if($class->homeroom_teacher)
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700">Wali Kelas:</p>
                                <p class="text-sm text-gray-900">{{ $class->homeroom_teacher->user->name }}</p>
                            </div>
                        @endif

                        <!-- Description -->
                        @if($class->description)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">{{ Str::limit($class->description, 100) }}</p>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route("classes.show", $class) }}" 
                               class="flex-1 text-center bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-2 rounded text-sm font-medium">
                                Detail
                            </a>
                            @can("update", $class)
                                <a href="{{ route("classes.edit", $class) }}" 
                                   class="flex-1 text-center bg-yellow-50 text-yellow-600 hover:bg-yellow-100 px-3 py-2 rounded text-sm font-medium">
                                    Edit
                                </a>
                            @endcan
                            @can("delete", $class)
                                <form action="{{ route("classes.destroy", $class) }}" 
                                      method="POST" 
                                      class="flex-1"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" 
                                            class="w-full bg-red-50 text-red-600 hover:bg-red-100 px-3 py-2 rounded text-sm font-medium">
                                        Hapus
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kelas</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if(request()->anyFilled(["search", "grade"]))
                                Tidak ada kelas yang sesuai dengan kriteria pencarian.
                            @else
                                Mulai dengan menambahkan kelas baru.
                            @endif
                        </p>
                        @can("create", App\Models\SchoolClass::class)
                            <div class="mt-6">
                                <a href="{{ route("classes.create") }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Tambah Kelas
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($classes->hasPages())
            <div class="mt-6">
                {{ $classes->appends(request()->query())->links() }}
            </div>
        @endif

        <!-- Summary Stats -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Total Kelas</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $classes->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $classes->sum("students_count") ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Kapasitas</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $classes->sum("max_students") ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Dengan Wali Kelas</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $classes->whereNotNull("homeroom_teacher_id")->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
