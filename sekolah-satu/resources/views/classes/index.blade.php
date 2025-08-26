@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Manajemen Kelas</h1>
                    <p class="text-gray-600 mt-1">Kelola data kelas sekolah</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('classes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Kelas
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('classes.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Kelas</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Nama kelas..."
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                    <select name="grade_level" id="grade_level" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Tingkat</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('grade_level') == $i ? 'selected' : '' }}>
                                Kelas {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-blue-500 rounded-full p-3">
                                <i class="fas fa-school text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Kelas</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $classes->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-green-500 rounded-full p-3">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $classes->sum(function($class) { return $class->students->count(); }) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-yellow-500 rounded-full p-3">
                                <i class="fas fa-check-circle text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Kelas Aktif</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $classes->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-purple-500 rounded-full p-3">
                                <i class="fas fa-chart-bar text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Rata-rata Siswa</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $classes->count() > 0 ? round($classes->sum(function($class) { return $class->students->count(); }) / $classes->count()) : 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($classes->count() > 0)
            <!-- Classes Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Data Kelas</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Kelas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tingkat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah Siswa
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kapasitas Max
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($classes as $class)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-school text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $class->name }}
                                                </div>
                                                @if($class->description)
                                                <div class="text-sm text-gray-500">
                                                    {{ Str::limit($class->description, 50) }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $class->code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Kelas {{ $class->grade_level }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-semibold">{{ $class->students->count() }}</span> siswa
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $class->max_students }} siswa
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($class->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('classes.show', $class->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('classes.edit', $class->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($classes->hasPages())
                <div class="bg-gray-50 px-6 py-4">
                    {{ $classes->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        @else
            <!-- No Classes -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-school text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Kelas</h3>
                <p class="text-gray-500 mb-4">Belum ada kelas yang terdaftar. Mulai buat kelas baru!</p>
                <a href="{{ route('classes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Kelas
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
