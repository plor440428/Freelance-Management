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
