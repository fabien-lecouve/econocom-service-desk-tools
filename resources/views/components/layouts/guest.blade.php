<!DOCTYPE html>
<html lang="en">

<x-layouts.head :title="$title ?? null" />

<body>
    <div class="guest">

        {{ $slot }}

    </div>
</body>

</html>
