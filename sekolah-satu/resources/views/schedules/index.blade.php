@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Manajemen Jadwal</h1>
                    <p class="text-gray-600 mt-1">Kelola jadwal pelajaran sekolah</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('schedules.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Jadwal
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('schedules.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="class_id" id="class_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Guru</label>
                    <select name="teacher_id" id="teacher_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Guru</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                    <select name="day_of_week" id="day_of_week" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Hari</option>
                        @foreach($days as $day_num => $day_name)
                            <option value="{{ $day_num }}" {{ request('day_of_week') == $day_num ? 'selected' : '' }}>
                                {{ $day_name }}
                            </option>
                        @endforeach
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

        @if($schedules->count() > 0)
            <!-- Schedules Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Jadwal Pelajaran</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hari
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mata Pelajaran
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Guru
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kelas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ruangan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($schedules as $schedule)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $days[$schedule->day_of_week] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $schedule->subject->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $schedule->teacher->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $schedule->class->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $schedule->room ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('schedules.show', $schedule->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('schedules.edit', $schedule->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
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
                @if($schedules->hasPages())
                <div class="bg-gray-50 px-6 py-4">
                    {{ $schedules->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        @else
            <!-- No Schedules -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-calendar text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Jadwal</h3>
                <p class="text-gray-500 mb-4">Belum ada jadwal yang terdaftar. Mulai buat jadwal pelajaran!</p>
                <a href="{{ route('schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Jadwal
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
