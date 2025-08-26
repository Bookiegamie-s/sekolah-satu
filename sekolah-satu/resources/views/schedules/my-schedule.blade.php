@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
                    <p class="text-gray-600 mt-1">{{ auth()->user()->name }}</p>
                    @if(auth()->user()->hasRole('student') && auth()->user()->student && auth()->user()->student->class)
                        <p class="text-sm text-blue-600">Kelas: {{ auth()->user()->student->class->name }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <div class="bg-blue-100 rounded-lg p-3">
                        <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        @if($schedules->count() > 0)
            <!-- Schedule Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Jadwal Mingguan</h2>
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
                                @if(auth()->user()->hasRole('student'))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Guru
                                </th>
                                @else
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kelas
                                </th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ruangan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($schedules->groupBy('day_of_week') as $day => $daySchedules)
                                @foreach($daySchedules as $index => $schedule)
                                    <tr class="hover:bg-gray-50">
                                        @if($index === 0)
                                            <td class="px-6 py-4 whitespace-nowrap align-top" rowspan="{{ $daySchedules->count() }}">
                                                <div class="flex items-center">
                                                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                                                        <i class="fas fa-calendar text-blue-600"></i>
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-900">
                                                        {{ $days[$day] }}
                                                    </span>
                                                </div>
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-book text-green-500 mr-2"></i>
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ $schedule->subject->name }}
                                                </span>
                                            </div>
                                        </td>
                                        @if(auth()->user()->hasRole('student'))
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-user text-purple-500 mr-2"></i>
                                                <span class="text-sm text-gray-900">
                                                    {{ $schedule->teacher->user->name }}
                                                </span>
                                            </div>
                                        </td>
                                        @else
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-school text-orange-500 mr-2"></i>
                                                <span class="text-sm text-gray-900">
                                                    {{ $schedule->class->name }}
                                                </span>
                                            </div>
                                        </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500">
                                                {{ $schedule->room ?? 'Belum ditentukan' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Schedule Statistics -->
                <div class="bg-gray-50 px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $schedules->count() }}</div>
                            <div class="text-sm text-gray-500">Total Jadwal</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $schedules->groupBy('day_of_week')->count() }}</div>
                            <div class="text-sm text-gray-500">Hari Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">
                                @if(auth()->user()->hasRole('student'))
                                    {{ $schedules->groupBy('subject_id')->count() }}
                                @else
                                    {{ $schedules->groupBy('class_id')->count() }}
                                @endif
                            </div>
                            <div class="text-sm text-gray-500">
                                @if(auth()->user()->hasRole('student'))
                                    Mata Pelajaran
                                @else
                                    Kelas Diajar
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No Schedule -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Jadwal</h3>
                @if(auth()->user()->hasRole('student'))
                    <p class="text-gray-500 mb-4">Jadwal kelas Anda belum tersedia. Silakan hubungi bagian akademik.</p>
                @else
                    <p class="text-gray-500 mb-4">Anda belum memiliki jadwal mengajar. Silakan hubungi bagian akademik.</p>
                @endif
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
