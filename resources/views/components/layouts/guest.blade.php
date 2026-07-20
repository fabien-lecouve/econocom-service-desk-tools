<!DOCTYPE html>
<html lang="en">

<x-layouts.head :title="$title ?? null" />

<body>
    <div class="guest">

        <nav class="navbar bg-base-100">
            <div class="navbar-start">
                <a href="/" class="btn btn-ghost text-xl">🐦 Chirper</a>
            </div>
            <div class="navbar-end gap-2">
                <a href="#" class="btn btn-ghost btn-sm">Sign In</a>
                <a href="#" class="btn btn-primary btn-sm">Sign Up</a>
            </div>
        </nav>

        <div class="main">
            {{ $slot }}
        </div>

    </div>
</body>

</html>
