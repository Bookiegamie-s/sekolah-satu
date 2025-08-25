<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fas fa-school mr-2 text-blue-600"></i>
                Dashboard Sekolah
            </h2>
            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                @if(auth()->user()->roles->count() > 0)
                    {{ auth()->user()->getRoleNames()->first() }}
                @else
                    Pending Role
                @endif
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg mb-8 text-white">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="opacity-90">Sistem Manajemen Sekolah Digital</p>
                    @if(auth()->user()->roles->count() == 0)
                        <div class="mt-4 bg-yellow-500/20 border border-yellow-300 rounded-lg p-3">
                            <p class="text-sm">⚠️ Role Anda belum ditetapkan. Silakan hubungi administrator.</p>
                        </div>
                    @endif
                </div>
            </div>

            @if(auth()->user()->roles->count() > 0)
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @can('manage_users')
                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users text-2xl text-blue-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Users</p>
                                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('manage_teachers')
                <!-- Total Teachers -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-chalkboard-teacher text-2xl text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Guru</p>
                                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Teacher::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('manage_students')
                <!-- Total Students -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-graduate text-2xl text-yellow-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Siswa</p>
                                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Student::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('manage_books')
                <!-- Total Books -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-book text-2xl text-purple-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Buku</p>
                                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Book::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                        Aksi Cepat
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @can('manage_users')
                        <a href="{{ route('users.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-users text-blue-600 text-xl mr-3"></i>
                            <span class="font-medium text-blue-900">Kelola Users</span>
                        </a>
                        @endcan

                        @can('manage_teachers')
                        <a href="{{ route('teachers.index') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <i class="fas fa-chalkboard-teacher text-green-600 text-xl mr-3"></i>
                            <span class="font-medium text-green-900">Kelola Guru</span>
                        </a>
                        @endcan

                        @can('manage_students')
                        <a href="{{ route('students.index') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-200">
                            <i class="fas fa-user-graduate text-yellow-600 text-xl mr-3"></i>
                            <span class="font-medium text-yellow-900">Kelola Siswa</span>
                        </a>
                        @endcan

                        @can('view_students')
                        @cannot('manage_students')
                        <a href="{{ route('students.index') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-200">
                            <i class="fas fa-user-graduate text-yellow-600 text-xl mr-3"></i>
                            <span class="font-medium text-yellow-900">Data Siswa</span>
                        </a>
                        @endcannot
                        @endcan

                        @can('manage_books')
                        <a href="{{ route('books.index') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-200">
                            <i class="fas fa-book text-purple-600 text-xl mr-3"></i>
                            <span class="font-medium text-purple-900">Kelola Buku</span>
                        </a>
                        @endcan

                        @can('manage_classes')
                        <a href="{{ route('classes.index') }}" class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-200">
                            <i class="fas fa-school text-indigo-600 text-xl mr-3"></i>
                            <span class="font-medium text-indigo-900">Kelola Kelas</span>
                        </a>
                        @endcan

                        @can('manage_schedules')
                        <a href="{{ route('schedules.index') }}" class="flex items-center p-4 bg-teal-50 rounded-lg hover:bg-teal-100 transition duration-200">
                            <i class="fas fa-calendar text-teal-600 text-xl mr-3"></i>
                            <span class="font-medium text-teal-900">Kelola Jadwal</span>
                        </a>
                        @endcan

                        @can('view_own_grades')
                        <a href="{{ route('grades.my') }}" class="flex items-center p-4 bg-pink-50 rounded-lg hover:bg-pink-100 transition duration-200">
                            <i class="fas fa-chart-line text-pink-600 text-xl mr-3"></i>
                            <span class="font-medium text-pink-900">Nilai Saya</span>
                        </a>
                        @endcan

                        @can('view_own_schedule')
                        <a href="{{ route('schedules.my') }}" class="flex items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition duration-200">
                            <i class="fas fa-calendar-alt text-orange-600 text-xl mr-3"></i>
                            <span class="font-medium text-orange-900">Jadwal Saya</span>
                        </a>
                        @endcan

                        @hasrole('student')
                        @if(auth()->user()->student)
                        <a href="{{ route('students.show', auth()->user()->student->id) }}" class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-200">
                            <i class="fas fa-id-card text-indigo-600 text-xl mr-3"></i>
                            <span class="font-medium text-indigo-900">Profil Saya</span>
                        </a>
                        @else
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-gray-400 text-xl mr-3"></i>
                            <span class="font-medium text-gray-500">Profil belum tersedia</span>
                        </div>
                        @endif
                        @endhasrole

                        @hasrole('teacher')
                        @if(auth()->user()->teacher)
                        <a href="{{ route('teachers.show', auth()->user()->teacher->id) }}" class="flex items-center p-4 bg-teal-50 rounded-lg hover:bg-teal-100 transition duration-200">
                            <i class="fas fa-id-card text-teal-600 text-xl mr-3"></i>
                            <span class="font-medium text-teal-900">Profil Saya</span>
                        </a>
                        @else
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-gray-400 text-xl mr-3"></i>
                            <span class="font-medium text-gray-500">Profil belum tersedia</span>
                        </div>
                        @endif
                        @endhasrole
                    </div>
                </div>
            </div>

            @else
            <!-- Dashboard untuk User tanpa Role -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-8 text-center">
                    <div class="mx-auto w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-user-clock text-yellow-600 text-3xl"></i>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Akun Sedang Diproses</h2>
                    
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Akun Anda telah berhasil dibuat, namun role/peran Anda belum ditetapkan oleh administrator.
                    </p>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 max-w-lg mx-auto">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                            <div class="text-left">
                                <h4 class="font-semibold text-blue-900 mb-2">Langkah Selanjutnya:</h4>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• Hubungi administrator sekolah</li>
                                    <li>• Sebutkan nama lengkap dan email Anda</li>
                                    <li>• Tunggu konfirmasi penetapan role</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-user-edit mr-2"></i>
                            Edit Profil
                        </a>
                        
                        <button type="button" onclick="location.reload()" 
                                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Refresh
                        </button>
                    </div>
                    
                    <div class="mt-8 text-sm text-gray-500">
                        <p>Butuh bantuan? Hubungi administrator di: 
                            <a href="mailto:admin@sekolah.edu" class="text-blue-600 hover:underline">admin@sekolah.edu</a>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Activity (placeholder for future development) -->
            <div class="mt-8 bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-clock mr-2 text-gray-500"></i>
                        Aktivitas Terbaru
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-500 text-center py-8">
                        <i class="fas fa-info-circle mr-2"></i>
                        Fitur aktivitas terbaru akan segera hadir!
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
