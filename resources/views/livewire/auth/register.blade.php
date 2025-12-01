<div>
    <div class="min-h-screen bg-gray-400 rounded-xl flex items-center justify-center py-12 px-12 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full bg-white rounded-lg shadow-md overflow-hidden grid grid-cols-1 md:grid-cols-2">
            <!-- Illustration / left column (hidden on small screens) -->
            <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-700 p-8">
                <div class="text-center text-white px-6">
                    <h3 class="text-3xl font-bold mb-2">Join Us</h3>
                    <p class="text-gray-200">Create an account to start managing your projects and tasks.</p>
                </div>
            </div>

            <!-- Form column -->
            <div class="p-8 sm:p-10">
                <div class="max-w-2xl mx-auto">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-extrabold text-gray-900">Create your account</h2>
                        <p class="mt-2 text-sm text-gray-600">Fill in the details below to get started</p>
                    </div>

                    <form wire:submit.prevent="register" class="space-y-6" novalidate>
                        <div>
                            <label for="name" class="sr-only">Full Name</label>
                            <input
                                id="name"
                                type="text"
                                wire:model.defer="name"
                                autocomplete="name"
                                placeholder="Full name"
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

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
                            <input
                                id="password"
                                type="password"
                                wire:model.defer="password"
                                autocomplete="new-password"
                                placeholder="Create a password (min. 6 characters)"
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="sr-only">Confirm Password</label>
                            <input
                                id="password_confirmation"
                                type="password"
                                wire:model.defer="password_confirmation"
                                autocomplete="new-password"
                                placeholder="Confirm your password"
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
                            <select
                                id="role"
                                wire:model.defer="role"
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <option value="customer">Customer</option>
                                <option value="freelance">Freelancer</option>
                            </select>
                            @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="w-full cursor-pointer flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-white bg-black hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-black">
                                <span wire:loading.remove>Create Account</span>
                                <div wire:loading class="inline-flex flex-row items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white inline-flex items-center justify-center" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <div>Creating account...</div>
                                </div>
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Already have an account?
                                <a href="{{ route('login') }}" class="font-medium text-black hover:underline">Sign in here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
