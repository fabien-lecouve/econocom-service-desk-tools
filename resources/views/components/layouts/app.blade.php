<!DOCTYPE html>
<html lang="en">

<x-layouts.head :title="$title ?? null" />

<body>

    {{ $slot }}

    @stack('scripts')
</body>
</html>
