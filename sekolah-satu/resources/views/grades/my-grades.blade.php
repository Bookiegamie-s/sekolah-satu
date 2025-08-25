@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Nilai Saya</h1>
                    <p class="text-gray-600 mt-1">{{ $student->user->name }} - {{ $student->student_id }}</p>
                    @if($student->schoolClass)
                        <p class="text-sm text-blue-600">Kelas: {{ $student->schoolClass->name }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <div class="bg-blue-100 rounded-lg p-3">
                        <i class="fas fa-chart-line text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        @if($gradesByYear->count() > 0)
            <!-- Grades by Academic Year -->
            @foreach($gradesByYear as $academicYear => $semesters)
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-4 rounded-t-lg">
                        <h2 class="text-xl font-semibold">Tahun Akademik {{ $academicYear }}</h2>
                    </div>
                    
                    @foreach($semesters as $semester => $semesterGrades)
                        <div class="px-6 py-4 border-b border-gray-200 last:border-b-0">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                Semester {{ $semester }}
                            </h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Mata Pelajaran
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tugas
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                UTS
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                UAS
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nilai Akhir
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Grade
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal Input
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($semesterGrades as $grade)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-book text-blue-500 mr-2"></i>
                                                        <span class="text-sm font-medium text-gray-900">
                                                            {{ $grade->subject->name ?? 'Mata Pelajaran Tidak Ditemukan' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm text-gray-900">{{ $grade->assignment_score ?? '-' }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm text-gray-900">{{ $grade->midterm_score ?? '-' }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm text-gray-900">{{ $grade->final_score ?? '-' }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm font-semibold text-gray-900">{{ $grade->total_score ?? '-' }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($grade->grade)
                                                        @php
                                                            $gradeColor = match($grade->grade) {
                                                                'A' => 'bg-green-100 text-green-800',
                                                                'B' => 'bg-blue-100 text-blue-800',
                                                                'C' => 'bg-yellow-100 text-yellow-800',
                                                                'D' => 'bg-orange-100 text-orange-800',
                                                                'E', 'F' => 'bg-red-100 text-red-800',
                                                                default => 'bg-gray-100 text-gray-800'
                                                            };
                                                        @endphp
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gradeColor }}">
                                                            {{ $grade->grade }}
                                                        </span>
                                                    @else
                                                        <span class="text-sm text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $grade->created_at->format('d/m/Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Semester Statistics -->
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-calculator text-blue-600 mr-2"></i>
                                        <div>
                                            <p class="text-sm font-medium text-blue-900">Rata-rata</p>
                                            <p class="text-lg font-bold text-blue-600">
                                                {{ number_format($semesterGrades->avg('total_score'), 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-trophy text-green-600 mr-2"></i>
                                        <div>
                                            <p class="text-sm font-medium text-green-900">Nilai Tertinggi</p>
                                            <p class="text-lg font-bold text-green-600">
                                                {{ $semesterGrades->max('total_score') ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-yellow-50 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-book-open text-yellow-600 mr-2"></i>
                                        <div>
                                            <p class="text-sm font-medium text-yellow-900">Total Mata Pelajaran</p>
                                            <p class="text-lg font-bold text-yellow-600">
                                                {{ $semesterGrades->count() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <!-- No Grades -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Nilai</h3>
                <p class="text-gray-500 mb-4">Nilai Anda belum diinput oleh guru. Silakan menunggu atau hubungi guru mata pelajaran.</p>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
