<div class="relative">
    <button id="profileBtn" class="flex items-center gap-2 px-2 py-1 rounded-full border border-slate-200 bg-white/80 hover:bg-white shadow-sm">
        <img src="{{ $userImage }}" alt="avatar" class="w-8 h-8 rounded-full object-cover" />
        <span class="hidden sm:inline text-sm font-medium text-slate-700">{{ $userName }}</span>
        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div id="profileMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-3 text-xs uppercase tracking-[0.2em] text-slate-400">Account</div>
        <div class="px-3 pb-3 text-sm text-slate-700">Signed in as <strong>{{ $userEmail }}</strong></div>
        <div>
            <button type="button" onclick="Livewire.dispatch('openEditProfileModal')" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50">Edit profile</button>
        </div>
        <div class="border-t border-slate-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 text-red-600">Logout</button>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');

        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function() {
                if (profileMenu && !profileMenu.classList.contains('hidden')) profileMenu.classList.add('hidden');
            });
        }
    })();
</script>
