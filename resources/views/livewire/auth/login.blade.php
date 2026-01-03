<div>
    <div class="h-full bg-gray-50 rounded-xl flex items-center justify-center py-0 px-0 sm:px-0 lg:px-0">
        <div class="max-w-6xl w-full bg-white rounded-lg shadow-md overflow-hidden grid grid-cols-1 md:grid-cols-2">
            <!-- Illustration / left column (hidden on small screens) -->
            <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-700 p-8">
                <div class="text-center text-white px-6">
                    <h3 class="text-3xl font-bold mb-2">Welcome Back</h3>
                    <p class="text-gray-200">Sign in to manage your projects and tasks.</p>
                </div>
            </div>

            <!-- Form column -->
            <div class="p-8 sm:p-10">
                <div class="max-w-2xl mx-auto">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-extrabold text-gray-900">Sign in to your account</h2>
                        <p class="mt-2 text-sm text-gray-600">Enter your details below to continue</p>
                    </div>

                    <form wire:submit.prevent="login" class="space-y-6" novalidate>
                        <div>
                            <label for="email" class="sr-only">Email</label>
                            <input
                                id="email"
                                type="email"
                                wire:model.defer="email"
                                autocomplete="username"
                                placeholder="you@example.com"
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <div class="relative" x-data="{ showPassword: false }">
                                <input
                                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    wire:model.defer="password"
                                    autocomplete="current-password"
                                    placeholder="Your password"
                                    class="appearance-none block w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center">
                                <input id="remember" type="checkbox" wire:model="remember" class="h-4 w-4 text-black border-gray-300 rounded" />
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>

                            <div class="text-sm">
                                <a href="#" class="font-medium text-black hover:underline">Forgot your password?</a>
                            </div>
                        </div>

                        <div>
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="w-full cursor-pointer flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-white bg-black hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-black">
                                <span wire:loading.remove>Sign in</span>
                                <div wire:loading class="inline-flex flex-row items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white inline-flex items-center justify-center" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <div>Signing in...</div>
                                </div>
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-medium text-black hover:underline">Sign up here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inline validation messages are shown under the fields; popup removed -->
</div>
