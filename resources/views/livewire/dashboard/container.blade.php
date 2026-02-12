<div>
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
                    @if($this->canSeeMenu('home'))
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
                    @endif

                    @if($this->canSeeMenu('projects'))
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
                    @endif

                    @if($this->canSeeMenu('tasks'))
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
                    @endif

                    @if($this->canSeeMenu('account'))
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
                    @endif

                    @if($this->canSeeMenu('approve'))
                    <li>
                        <button wire:click="setActive('approve')" class="cursor-pointer w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'approve') bg-slate-800 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <!--Boxicons v3.0.6 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                            </svg>
                            <span>Approve</span>
                        </button>
                    </li>
                    @endif

                    @if($this->canSeeMenu('settings'))
                    <li>
                        <button wire:click="setActive('settings')" class="cursor-pointer w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'settings') bg-slate-800 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <!--Boxicons v3.0.6 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4m0 6c-1.08 0-2-.92-2-2s.92-2 2-2 2 .92 2 2-.92 2-2 2"></path>
                                <path d="m20.42 13.4-.51-.29c.05-.37.08-.74.08-1.11s-.03-.74-.08-1.11l.51-.29c.96-.55 1.28-1.78.73-2.73l-1-1.73a2.006 2.006 0 0 0-2.73-.73l-.53.31c-.58-.46-1.22-.83-1.9-1.11v-.6c0-1.1-.9-2-2-2h-2c-1.1 0-2 .9-2 2v.6c-.67.28-1.31.66-1.9 1.11l-.53-.31c-.96-.55-2.18-.22-2.73.73l-1 1.73c-.55.96-.22 2.18.73 2.73l.51.29c-.05.37-.08.74-.08 1.11s.03.74.08 1.11l-.51.29c-.96.55-1.28 1.78-.73 2.73l1 1.73c.55.95 1.77 1.28 2.73.73l.53-.31c.58.46 1.22.83 1.9 1.11v.6c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2v-.6a8.7 8.7 0 0 0 1.9-1.11l.53.31c.95.55 2.18.22 2.73-.73l1-1.73c.55-.96.22-2.18-.73-2.73m-2.59-2.78c.11.45.17.92.17 1.38s-.06.92-.17 1.38a1 1 0 0 0 .47 1.11l1.12.65-1 1.73-1.14-.66c-.38-.22-.87-.16-1.19.14-.68.65-1.51 1.13-2.38 1.4-.42.13-.71.52-.71.96v1.3h-2v-1.3c0-.44-.29-.83-.71-.96-.88-.27-1.7-.75-2.38-1.4a1.01 1.01 0 0 0-1.19-.15l-1.14.66-1-1.73 1.12-.65c.39-.22.58-.68.47-1.11-.11-.45-.17-.92-.17-1.38s.06-.93.17-1.38A1 1 0 0 0 5.7 9.5l-1.12-.65 1-1.73 1.14.66c.38.22.87.16 1.19-.14.68-.65 1.51-1.13 2.38-1.4.42-.13.71-.52.71-.96v-1.3h2v1.3c0 .44.29.83.71.96.88.27 1.7.75 2.38 1.4.32.31.81.36 1.19.14l1.14-.66 1 1.73-1.12.65c-.39.22-.58.68-.47 1.11Z"></path>
                            </svg>
                            <span>Settings</span>
                        </button>
                    </li>
                    @endif
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
                        @livewire('dashboard.navbar-user')
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
                    @case('approve')
                    @livewire('dashboard.approve')
                    @break
                    @case('settings')
                    @livewire('dashboard.settings')
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

        const toggleSidebar = function() {
            if (!sidebar) return;
            sidebar.classList.toggle('-translate-x-full');
        };

        toggle && toggle.addEventListener('click', toggleSidebar);
        closeBtn && closeBtn.addEventListener('click', toggleSidebar);
    })();
</script>

@livewire('dashboard.edit-profile')
</div>
