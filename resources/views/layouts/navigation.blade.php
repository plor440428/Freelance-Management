<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-slate-800">FreelMane</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-600">{{ Auth::user()->name ?? '' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
