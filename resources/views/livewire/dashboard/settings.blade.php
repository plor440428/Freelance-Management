<div x-data="{ activeTab: 'profile' }" class="settings-shell relative overflow-hidden">
    <div class="settings-orb settings-orb--1"></div>
    <div class="settings-orb settings-orb--2"></div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative">
        <!-- Header -->
        <div class="mb-10 fade-up">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/80 border border-slate-200 px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Account Center
            </span>
            <h2 class="settings-title text-4xl sm:text-5xl text-slate-900 mt-4">Settings</h2>
            <p class="text-sm sm:text-base font-medium text-slate-600 mt-3 max-w-2xl">Manage your account details, security, and billing preferences in one place.</p>
        </div>

        <!-- Tabs Navigation -->
        <div class="panel mb-8 overflow-hidden fade-up delay-1">
            <div class="flex overflow-x-auto border-b border-slate-200">
                <button @click="activeTab = 'profile'" 
                        :class="activeTab === 'profile' ? 'tab-btn-active' : 'tab-btn-inactive'"
                        class="tab-btn">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Profile</span>
                    </div>
                </button>

                <button @click="activeTab = 'password'" 
                        :class="activeTab === 'password' ? 'tab-btn-active' : 'tab-btn-inactive'"
                        class="tab-btn">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        <span>Security</span>
                    </div>
                </button>

                @if($paymentSlipUrl)
                <button @click="activeTab = 'payment'" 
                        :class="activeTab === 'payment' ? 'tab-btn-active' : 'tab-btn-inactive'"
                        class="tab-btn">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Payment Proof</span>
                    </div>
                </button>
                @endif

                @if(auth()->user()->role === 'admin')
                <button @click="activeTab = 'pricing'" 
                        :class="activeTab === 'pricing' ? 'tab-btn-active' : 'tab-btn-inactive'"
                        class="tab-btn">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Pricing</span>
                        <span class="px-2.5 py-0.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg ml-2">Admin</span>
                    </div>
                </button>
                @endif
            </div>
        </div>

        <!-- Tab Content -->
        <div class="space-y-6">
            <!-- Profile Tab -->
            <div x-show="activeTab === 'profile'" x-cloak>
                <div class="panel p-7 fade-up delay-2">
                    <h3 class="section-title text-2xl text-slate-900 mb-7 flex items-center">
                        <div class="w-1 h-8 bg-gradient-to-b from-blue-600 to-sky-400 rounded-full mr-3"></div>
                        Profile Information
                    </h3>
                    
                    <form wire:submit.prevent="updateProfile">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                            <!-- Profile Image Column -->
                            <div class="md:col-span-1 flex flex-col items-center md:items-start">
                                <label class="block text-xs font-bold text-gray-700 mb-4 uppercase tracking-widest">Profile Picture</label>
                                <div class="flex flex-col items-center w-full">
                                    @if ($previewUrl)
                                        <img src="{{ $previewUrl }}" alt="Profile" class="w-40 h-40 rounded-xl object-cover border-4 border-blue-100 shadow-md mb-4" />
                                    @else
                                        <div class="w-40 h-40 rounded-xl bg-gradient-to-br from-blue-600 to-sky-500 flex items-center justify-center text-white text-5xl font-black shadow-md mb-4">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <div class="w-full">
                                        <input type="file" wire:model.live="profileImage" accept="image/*" 
                                               class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 transition" />
                                        @error('profileImage')
                                            <p class="text-red-600 text-xs font-medium mt-2">{{ $message }}</p>
                                        @enderror
                                        <div wire:loading wire:target="profileImage" class="text-xs text-blue-700 font-medium mt-2 flex items-center gap-2">
                                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Uploading image...
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium mt-2">JPG, PNG or GIF (MAX. 2MB)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Fields Column -->
                            <div class="md:col-span-1 space-y-5">
                                <!-- Name -->
                                <div>
                                     <label class="block text-xs font-bold text-slate-700 mb-2.5 uppercase tracking-widest">Full Name</label>
                                    <input type="text" wire:model="name" 
                                         class="w-full px-4 py-3 border border-slate-200 rounded-lg text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                           placeholder="Enter your full name" />
                                    @error('name')
                                        <p class="text-red-600 text-xs font-semibold mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email (Read-only) -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2.5 uppercase tracking-widest">Email Address</label>
                                    <div class="relative">
                                        <input type="email" value="{{ $email }}" disabled 
                                               class="w-full px-4 py-3 border border-slate-200 rounded-lg bg-slate-50 text-slate-500 cursor-not-allowed text-sm font-medium" />
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-2 flex items-center gap-1.5 font-medium">
                                        <svg class="w-4 h-4 flex-shrink-0 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        Email cannot be changed for security reasons
                                    </p>
                                </div>

                                <!-- Role Badge -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2.5 uppercase tracking-widest">Account Type</label>
                                    <div class="w-full p-3.5 bg-gradient-to-r from-blue-50 to-white border border-blue-200 rounded-lg flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-600 uppercase tracking-widest">Current Role</p>
                                            <p class="font-black text-lg text-slate-900 capitalize">{{ auth()->user()->role }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="md:col-span-2 pt-4 border-t border-slate-200 mt-6">
                                    <button type="submit" 
                                            wire:loading.attr="disabled"
                                            wire:target="updateProfile, profileImage"
                                            class="btn-primary">
                                        <span wire:loading.remove wire:target="updateProfile, profileImage">Save Changes</span>
                                        <span wire:loading wire:target="updateProfile, profileImage" class="flex items-center gap-2">
                                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Saving...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Tab -->
            <div x-show="activeTab === 'password'" x-cloak>
                <div class="panel p-7 fade-up delay-2">
                    <h3 class="section-title text-2xl text-slate-900 mb-2 flex items-center">
                        <div class="w-1 h-8 bg-gradient-to-b from-amber-600 to-orange-400 rounded-full mr-3"></div>
                        Change Password
                    </h3>
                    <p class="text-sm font-medium text-slate-600 mb-7 ml-6">Update your password to keep your account secure</p>
                    
                    <form wire:submit.prevent="updatePassword" class="max-w-2xl">
                        <div class="space-y-5">
                            <!-- Current Password -->
                            <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2.5 uppercase tracking-widest">Current Password</label>
                                <input type="password" wire:model="current_password" 
                                        class="w-full px-4 py-3 border border-slate-200 rounded-lg text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                       placeholder="Enter current password" />
                                @error('current_password')
                                    <p class="text-red-600 text-xs font-semibold mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2.5 uppercase tracking-widest">New Password</label>
                                <input type="password" wire:model="new_password" 
                                        class="w-full px-4 py-3 border border-slate-200 rounded-lg text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                       placeholder="Enter new password (min. 8 characters)" />
                                @error('new_password')
                                    <p class="text-red-600 text-xs font-semibold mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2.5 uppercase tracking-widest">Confirm New Password</label>
                                <input type="password" wire:model="new_password_confirmation" 
                                       class="w-full px-4 py-3 border border-slate-200 rounded-lg text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                       placeholder="Confirm new password" />
                            </div>

                            <!-- Info Box -->
                            <div class="bg-gradient-to-r from-blue-50 to-white border border-blue-200 rounded-xl p-5 mt-6">
                                <div class="flex gap-4">
                                    <svg class="w-6 h-6 text-blue-700 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="font-black text-blue-900 mb-2">Password Requirements:</p>
                                        <ul class="list-disc list-inside space-y-1 text-blue-700 font-medium">
                                            <li>Minimum 8 characters</li>
                                            <li>Include uppercase and lowercase letters</li>
                                            <li>Include at least one number</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    class="btn-primary mt-6 w-full md:w-auto">
                                <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                                <span wire:loading wire:target="updatePassword">Updating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payment Proof Tab -->
            @if($paymentSlipUrl)
            <div x-show="activeTab === 'payment'" x-cloak>
                <div class="panel p-7 fade-up delay-2">
                    <h3 class="section-title text-2xl text-slate-900 mb-2 flex items-center">
                        <div class="w-1 h-8 bg-gradient-to-b from-blue-600 to-sky-400 rounded-full mr-3"></div>
                        Payment Proof
                    </h3>
                    <p class="text-sm font-medium text-slate-600 mb-7 ml-6">Payment slip submitted during registration</p>
                    
                    <div class="flex flex-col md:flex-row gap-8 items-start md:max-w-4xl">
                        <div class="flex-shrink-0 md:w-80">
                            <img src="{{ $paymentSlipUrl }}" alt="Payment Slip" 
                                 class="w-full h-auto rounded-xl border-2 border-gray-200 shadow-md hover:shadow-lg transition-shadow cursor-pointer"
                                 onclick="window.open('{{ $paymentSlipUrl }}', '_blank')" />
                        </div>
                        <div class="flex-1 md:min-w-0">
                            <div class="bg-gradient-to-r from-blue-50 to-white border border-blue-200 rounded-xl p-5 mb-5">
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="font-black text-blue-900">Payment Verified</p>
                                        <p class="text-sm text-blue-700 mt-1 font-medium">Your payment has been confirmed and your account is active</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ $paymentSlipUrl }}" target="_blank" 
                                   class="btn-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    View Full Size
                                </a>
                                
                                <a href="{{ $paymentSlipUrl }}" download 
                                   class="btn-secondary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Pricing Tab (Admin Only) -->
            @if(auth()->user()->role === 'admin')
            <div x-show="activeTab === 'pricing'" x-cloak>
                <div class="panel p-7 fade-up delay-2">
                    <div class="flex items-center justify-between mb-7">
                        <div>
                            <h3 class="section-title text-2xl text-slate-900 flex items-center">
                                <div class="w-1 h-8 bg-gradient-to-b from-slate-700 to-slate-500 rounded-full mr-3"></div>
                                Pricing Settings
                            </h3>
                            <p class="text-sm font-medium text-slate-600 mt-2 ml-6">Manage lifetime pricing for different account types</p>
                        </div>
                        <span class="px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg whitespace-nowrap">Admin Only</span>
                    </div>
                    
                    <form wire:submit.prevent="savePricing">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 md:max-w-2xl">
                            <!-- Freelance Price -->
                            <div class="p-6 border-2 border-blue-200 rounded-xl bg-gradient-to-br from-blue-50 to-white shadow-sm hover:shadow-md transition">
                                <div class="flex items-center gap-4 mb-5">
                                    <div class="w-14 h-14 rounded-lg bg-blue-600 flex items-center justify-center shadow-md flex-shrink-0">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-gray-900">Freelance</h4>
                                        <p class="text-xs font-semibold text-blue-700 uppercase tracking-widest">Lifetime Access</p>
                                    </div>
                                </div>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-bold">฿</span>
                                    <input type="number" wire:model="freelance_price" step="0.01" min="0"
                                        class="w-full pl-8 pr-3 py-3 border border-blue-300 rounded-lg text-lg font-black text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                        placeholder="2990" />
                                </div>
                                @error('freelance_price')
                                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Customer Price -->
                            <div class="p-6 border-2 border-blue-200 rounded-xl bg-gradient-to-br from-blue-50 to-white shadow-sm hover:shadow-md transition">
                                <div class="flex items-center gap-4 mb-5">
                                    <div class="w-14 h-14 rounded-lg bg-blue-600 flex items-center justify-center shadow-md flex-shrink-0">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-gray-900">Customer</h4>
                                        <p class="text-xs font-semibold text-blue-700 uppercase tracking-widest">Lifetime Access</p>
                                    </div>
                                </div>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-bold">฿</span>
                                    <input type="number" wire:model="customer_price" step="0.01" min="0"
                                        class="w-full pl-8 pr-3 py-3 border border-blue-300 rounded-lg text-lg font-black text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                        placeholder="1990" />
                                </div>
                                @error('customer_price')
                                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-amber-50 to-white border border-amber-200 rounded-xl p-5 mb-6 md:max-w-2xl">
                            <div class="flex gap-4">
                                <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm">
                                    <p class="font-black text-amber-900">Important Notice:</p>
                                    <p class="mt-1 text-amber-800 font-medium">Price changes will take effect immediately. New registrations will see the updated pricing.</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="btn-primary w-full md:w-auto">
                            <span wire:loading.remove wire:target="savePricing">Save Pricing Settings</span>
                            <span wire:loading wire:target="savePricing">Saving...</span>
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap');

            [x-cloak] { display: none !important; }

            .settings-shell {
                --accent: #2563eb;
                --accent-dark: #1d4ed8;
                --panel-border: #e2e8f0;
                background: linear-gradient(180deg, #f8fafc 0%, #ffffff 45%, #eff6ff 100%);
                font-family: 'Manrope', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif;
            }

            .settings-title {
                font-family: 'Space Grotesk', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif;
                letter-spacing: -0.02em;
            }

            .section-title {
                font-family: 'Space Grotesk', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif;
                letter-spacing: -0.01em;
            }

            .panel {
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid var(--panel-border);
                border-radius: 16px;
                box-shadow: 0 18px 40px -30px rgba(15, 23, 42, 0.35);
                backdrop-filter: blur(6px);
            }

            .tab-btn {
                padding: 16px 24px;
                font-weight: 600;
                font-size: 0.9rem;
                white-space: nowrap;
                transition: all 0.2s ease;
            }

            .tab-btn-active {
                color: var(--accent);
                background: rgba(37, 99, 235, 0.08);
                box-shadow: inset 0 -2px 0 var(--accent);
            }

            .tab-btn-inactive {
                color: #64748b;
            }

            .tab-btn:hover {
                background: #f1f5f9;
                color: #0f172a;
            }

            .btn-primary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                background: var(--accent);
                color: #fff;
                font-weight: 600;
                box-shadow: 0 10px 20px -12px rgba(37, 99, 235, 0.6);
                transition: all 0.2s ease;
            }

            .btn-primary:hover {
                background: var(--accent-dark);
                transform: translateY(-1px);
            }

            .btn-primary:disabled {
                opacity: 0.6;
                cursor: not-allowed;
                transform: none;
            }

            .btn-secondary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                border: 1px solid #e2e8f0;
                color: #334155;
                background: #fff;
                font-weight: 600;
                transition: all 0.2s ease;
            }

            .btn-secondary:hover {
                background: #f8fafc;
            }

            .settings-orb {
                position: absolute;
                border-radius: 999px;
                filter: blur(0px);
                opacity: 0.6;
                animation: floatSlow 8s ease-in-out infinite;
                pointer-events: none;
            }

            .settings-orb--1 {
                width: 220px;
                height: 220px;
                background: radial-gradient(circle at 30% 30%, rgba(56, 189, 248, 0.4), rgba(37, 99, 235, 0));
                top: -60px;
                right: -40px;
            }

            .settings-orb--2 {
                width: 280px;
                height: 280px;
                background: radial-gradient(circle at 70% 30%, rgba(147, 197, 253, 0.45), rgba(37, 99, 235, 0));
                bottom: -120px;
                left: -60px;
                animation-delay: 1.5s;
            }

            .fade-up {
                animation: fadeUp 0.6s ease both;
            }

            .fade-up.delay-1 {
                animation-delay: 0.12s;
            }

            .fade-up.delay-2 {
                animation-delay: 0.24s;
            }

            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(12px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes floatSlow {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-10px);
                }
            }
        </style>
    </div>
</div>

