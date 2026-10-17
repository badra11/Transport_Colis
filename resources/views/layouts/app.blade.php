<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

     @stack('js')

        @if (session('swal'))
            <script>
                Swal.fire(@json(session('swal')));
            </script>
        @endif
</x-layouts::app.sidebar>
