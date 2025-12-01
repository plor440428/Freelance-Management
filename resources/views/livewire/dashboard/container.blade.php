<div class="min-h-screen bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-20 w-64 transform -translate-x-0 md:translate-x-0 transition-transform duration-200 bg-slate-900 text-white shadow-lg">
            <div class="h-16 flex items-center justify-between px-4 border-b border-slate-800">
                <div class="font-bold text-lg">FreelMane</div>
                <button id="sidebarClose" class="md:hidden p-2 rounded-md text-white hover:bg-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <button wire:click="setActive('home')" class="cursor-pointer w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'home') bg-slate-800 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <!--Boxicons v3.0.6 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                <path d="M4 2H2v19c0 .55.45 1 1 1h19v-2H4z"></path>
                                <path d="M19 18c.55 0 1-.45 1-1V5c0-.55-.45-1-1-1h-4c-.55 0-1 .45-1 1v12c0 .55.45 1 1 1zM16 6h2v10h-2zM11 18c.55 0 1-.45 1-1v-7c0-.55-.45-1-1-1H7c-.55 0-1 .45-1 1v7c0 .55.45 1 1 1zm-3-7h2v5H8z"></path>
                            </svg>
                            <span>Dashboard</span>
                        </button>
                    </li>
                    <li>
                        <button wire:click="setActive('projects')" class="cursor-pointer w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'projects') bg-slate-800 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <!--Boxicons v3.0.6 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                <path d="m20,4h-8.59l-1.41-1.41c-.38-.38-.88-.59-1.41-.59h-4.59c-1.1,0-2,.9-2,2v14c0,1.1.9,2,2,2h16c1.1,0,2-.9,2-2V6c0-1.1-.9-2-2-2Zm0,14H4s0-12,0-12h16v12Z"></path>
                            </svg>
                            <span>Projects</span>
                        </button>
                    </li>
                    <li>
                        <button wire:click="setActive('tasks')" class="cursor-pointer w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'tasks') bg-slate-800 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <!--Boxicons v3.0.6 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                <path d="m4 8.09-1.29-1.3-1.42 1.42L4 10.91l4.71-4.7-1.42-1.42zM4 16.09l-1.29-1.3-1.42 1.42L4 18.91l4.71-4.7-1.42-1.42zM10 15h12v2H10zM10 7h12v2H10z"></path>
                            </svg>
                            <span>Tasks</span>
                        </button>
                    </li>
                    <li>
                        <button wire:click="setActive('account')" class="cursor-pointer w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'account') bg-slate-800 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <!--Boxicons v3.0.6 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                <path d="m12,7c-2,0-3.5,1.5-3.5,3.5s1.5,3.5,3.5,3.5,3.5-1.5,3.5-3.5-1.5-3.5-3.5-3.5Zm0,5c-.88,0-1.5-.62-1.5-1.5s.62-1.5,1.5-1.5,1.5.62,1.5,1.5-.62,1.5-1.5,1.5Z"></path>
                                <path d="m19,3H5c-1.1,0-2,.9-2,2v14c0,1.1.9,2,2,2h14c1.1,0,2-.9,2-2V5c0-1.1-.9-2-2-2Zm-10.82,16c.41-1.16,1.51-2,2.82-2h2c1.3,0,2.4.84,2.82,2h-7.63Zm9.71,0c-.46-2.28-2.48-4-4.9-4h-2c-2.41,0-4.43,1.72-4.9,4h-1.1V5h14v14s-1.1,0-1.1,0Z"></path>
                            </svg>
                            <span>Account</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main content area -->
        <div class="flex-1 md:pl-64">
            <!-- Navbar -->
            <header class="sticky top-0 z-10 bg-white border-b border-slate-200">
                <div class="flex items-center justify-between h-16 px-4">
                    <div class="flex items-center gap-3">
                        <button id="sidebarToggle" class="p-2 rounded-md text-slate-700 hover:bg-slate-100 md:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h2 class="text-lg font-semibold capitalize">{{$active}}</h2>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="hidden sm:block">
                            <input type="search" placeholder="Search..." class="px-3 py-2 border rounded-md bg-slate-50" />
                        </div>

                        <!-- Profile -->
                        <div class="relative">
                            <button id="profileBtn" class="flex items-center gap-2 p-1 rounded hover:bg-slate-50">
                                <img src="https://i.pravatar.cc/40?u={{ auth()->user()->id }}" alt="avatar" class="w-8 h-8 rounded-full" />
                                <span class="hidden sm:inline text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 overflow-hidden">
                                <div class="p-3 text-sm text-slate-700">Signed in as <strong>{{ auth()->user()->email }}</strong></div>
                                <div class="border-t border-gray-200 ">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 text-red-600">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="p-6">
                <div class="bg-white rounded shadow p-4">
                    @switch($active)
                    @case('home')
                    @livewire('dashboard.home')
                    @break
                    @case('projects')
                    @livewire('dashboard.projects')
                    @break
                    @case('tasks')
                    @livewire('dashboard.tasks')
                    @break
                    @case('account')
                    @livewire('dashboard.account')
                    @break
                    @default
                    <div class="text-center py-8 text-slate-500">Unknown section</div>
                    @endswitch
                </div>
            </main>
        </div>
    </div>
</div>

<script>
    (function() {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');

        const toggleSidebar = function() {
            if (!sidebar) return;
            sidebar.classList.toggle('-translate-x-full');
        };

        toggle && toggle.addEventListener('click', toggleSidebar);
        closeBtn && closeBtn.addEventListener('click', toggleSidebar);

        profileBtn && profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function() {
            if (profileMenu && !profileMenu.classList.contains('hidden')) profileMenu.classList.add('hidden');
        });
    })();
</script>
