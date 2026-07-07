<!DOCTYPE html>
<html lang="en">

<x-layouts.head :title="$title ?? null" />

<body>
    <div class="dashboard">
        <x-layouts.sidebar />

        <div class="main">
            {{ $slot }}
        </div>
    </div>

    @stack('scripts')
</body>
</html>
