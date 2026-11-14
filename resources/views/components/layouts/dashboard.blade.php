<!DOCTYPE html>
<html lang="fr">

<x-layouts.head :title="$title ?? null" />

<body>
    <div
        class="dashboard"
        x-data="{ sidebarOpen: false }"
        @keydown.escape.window="sidebarOpen = false"
    >
        <x-layouts.sidebar />

        <main class="main">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
