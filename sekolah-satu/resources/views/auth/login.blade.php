<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-500 via-purple-600 to-indigo-700 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-school text-2xl text-blue-600"></i>
                </div>
                <h2 class="mt-6 text-3xl font-bold text-white">
                    SekolahSatu
                </h2>
                <p class="mt-2 text-sm text-blue-100">
                    Sistem Manajemen Sekolah Digital
                </p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-xl shadow-2xl p-8">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>
                            Email Address
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>
                            Password
                        </label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                                class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-3 px-4 rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </button>
                </form>

                <!-- Demo Credentials -->
                <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                        Demo Credentials
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        <div class="bg-white p-2 rounded border">
                            <div class="font-semibold text-red-600">Admin</div>
                            <div class="text-gray-600">admin@sekolah.test</div>
                            <div class="text-gray-500">password</div>
                        </div>
                        <div class="bg-white p-2 rounded border">
                            <div class="font-semibold text-green-600">Teacher</div>
                            <div class="text-gray-600">budi@sekolah.test</div>
                            <div class="text-gray-500">password</div>
                        </div>
                        <div class="bg-white p-2 rounded border">
                            <div class="font-semibold text-blue-600">Student</div>
                            <div class="text-gray-600">ahmad@sekolah.test</div>
                            <div class="text-gray-500">password</div>
                        </div>
                        <div class="bg-white p-2 rounded border">
                            <div class="font-semibold text-purple-600">Library</div>
                            <div class="text-gray-600">library@sekolah.test</div>
                            <div class="text-gray-500">password</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-white text-sm opacity-75">
                    © 2025 SekolahSatu. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
