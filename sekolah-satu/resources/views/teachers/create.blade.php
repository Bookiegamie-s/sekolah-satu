<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Tambah Guru") }}
            </h2>
            <a href="{{ route("teachers.index") }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route("teachers.store") }}" class="space-y-6">
                    @csrf

                    <!-- Personal Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       value="{{ old("name") }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       required>
                                @error("name")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       value="{{ old("email") }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       required>
                                @error("email")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       required>
                                @error("password")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       required>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="text" 
                                       name="phone" 
                                       id="phone"
                                       value="{{ old("phone") }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error("phone")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="address" 
                                          id="address"
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old("address") }}</textarea>
                                @error("address")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Teacher Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Guru</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- NIP -->
                            <div>
                                <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                                <input type="text" 
                                       name="nip" 
                                       id="nip"
                                       value="{{ old("nip") }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       required>
                                @error("nip")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Qualification -->
                            <div>
                                <label for="qualification" class="block text-sm font-medium text-gray-700">Kualifikasi Pendidikan</label>
                                <select name="qualification" 
                                        id="qualification"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required>
                                    <option value="">Pilih Kualifikasi</option>
                                    <option value="S1" @if(old("qualification") === "S1") selected @endif>S1</option>
                                    <option value="S2" @if(old("qualification") === "S2") selected @endif>S2</option>
                                    <option value="S3" @if(old("qualification") === "S3") selected @endif>S3</option>
                                    <option value="D3" @if(old("qualification") === "D3") selected @endif>D3</option>
                                    <option value="D4" @if(old("qualification") === "D4") selected @endif>D4</option>
                                </select>
                                @error("qualification")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Max Teaching Hours -->
                            <div>
                                <label for="max_teaching_hours" class="block text-sm font-medium text-gray-700">Maksimal Jam Mengajar</label>
                                <input type="number" 
                                       name="max_teaching_hours" 
                                       id="max_teaching_hours"
                                       value="{{ old("max_teaching_hours", 24) }}"
                                       min="1"
                                       max="40"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       required>
                                @error("max_teaching_hours")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" 
                                        id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required>
                                    <option value="active" @if(old("status") === "active") selected @endif>Aktif</option>
                                    <option value="inactive" @if(old("status") === "inactive") selected @endif>Tidak Aktif</option>
                                </select>
                                @error("status")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Subjects -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Mata Pelajaran</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($subjects as $subject)
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           name="subjects[]" 
                                           id="subject_{{ $subject->id }}"
                                           value="{{ $subject->id }}"
                                           @if(is_array(old("subjects")) && in_array($subject->id, old("subjects"))) checked @endif
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <label for="subject_{{ $subject->id }}" class="ml-2 text-sm text-gray-700">
                                        {{ $subject->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error("subjects")
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route("teachers.index") }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
