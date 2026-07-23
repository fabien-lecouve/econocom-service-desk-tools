<div class="category-tree__item">

    <div class="category-tree__row" style="padding-left: {{ $level * 2 }}rem;">

        <div class="category-tree__label">
            📁 {{ $category['label'] }}
        </div>

        <div class="category-tree__code">
            {{ $category['code'] }}
        </div>

        <div class="category-tree__actions">
            <a href="{{ route('categories.edit', ['project' => $project, 'category' => $category['id']]) }}">
                Modifier
            </a>

            {{-- <form action="{{ route('categories.destroy', ['project' => $project, 'category' => $category['id']]) }}"
                method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" onclick="return confirm('Supprimer cette catégorie ?')">
                    Supprimer
                </button>
            </form> --}}
        </div>

    </div>

    @foreach ($category['children'] as $child)
        @include('categories.partials.category', [
            'category' => $child,
            'level' => $level + 1,
        ])
    @endforeach

</div>
