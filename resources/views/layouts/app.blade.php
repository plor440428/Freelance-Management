<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'FreelMane' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body class="font-sans bg-slate-50 text-slate-900 antialiased">
    <div class="w-full">
        @livewire('toast')
        @yield('content')
    </div>

    @livewireScripts
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('notify', (data) => {
                const type = data.type || 'info';
                const message = data.message || '';

                let icon = 'info';
                let title = 'Notification';

                switch (type) {
                    case 'success':
                        icon = 'success';
                        title = 'Success';
                        break;
                    case 'error':
                        icon = 'error';
                        title = 'Error';
                        break;
                    case 'warning':
                        icon = 'warning';
                        title = 'Warning';
                        break;
                    case 'info':
                    default:
                        icon = 'info';
                        title = 'Info';
                        break;
                }

                Swal.fire({
                    icon: icon,
                    title: title,
                    text: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });

            Livewire.on('backToProjects', () => {
                Livewire.navigate('{{ route("dashboard.projects") }}');
            });

            Livewire.on('projectDeleted', (data) => {
                const targetUrl = data?.url || '{{ route("dashboard.projects") }}';

                if (typeof Livewire.navigate === 'function') {
                    Livewire.navigate(targetUrl);
                    return;
                }

                window.location.href = targetUrl;
            });
        });
    </script>
</body>
</html>
