<aside id="sidebar" class="fixed inset-y-0 left-0 z-20 w-64 transform -translate-x-0 md:translate-x-0 transition-transform duration-200 bg-slate-900 text-white shadow-lg">
  <div class="h-16 flex items-center px-4 border-b border-slate-800">
    <div class="font-bold text-lg">Awesome Kit</div>
  </div>
  <nav class="p-4">
    <ul class="space-y-2">
      <li>
        <button wire:click="setActive('home')" class="w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'home') bg-slate-800 @endif">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
          <span>Dashboard</span>
        </button>
      </li>
      <li>
        <button wire:click="setActive('projects')" class="w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'projects') bg-slate-800 @endif">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6M9 7h6"/></svg>
          <span>Projects</span>
        </button>
      </li>
      <li>
        <button wire:click="setActive('tasks')" class="w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'tasks') bg-slate-800 @endif">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18"/></svg>
          <span>Tasks</span>
        </button>
      </li>
      <li>
        <button wire:click="setActive('account')" class="w-full text-left flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 @if($active === 'account') bg-slate-800 @endif">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v4h6v-4c0-1.657-1.343-3-3-3zM12 4a4 4 0 110 8 4 4 0 010-8z"/></svg>
          <span>Account</span>
        </button>
      </li>
    </ul>
  </nav>
</aside>
