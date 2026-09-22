<div class="tree__item">

    <div class="tree__row">
        <div class="tree__label" style="padding-left: {{ $level * 2 }}rem;">
            <div class="icon icon--square icon-label">
                <i class="fa-solid fa-folder"></i>
            </div>
            <span>
                {{ $category['label'] }}
            </span>
        </div>

        <div class="tree__code">
            {{ $category['code'] }}
        </div>

        <div class="actions">
            @can('update', $category)
                <a class="actions__edit"
                    href="{{ route('projects.categories.edit', ['project' => $project, 'category' => $category['id']]) }}">
                    <i class="fa-solid fa-pen"></i>
                </a>
            @endcan

            @can('delete', $category)
                <form action="{{ route('projects.categories.destroy', ['project' => $project, 'category' => $category['id']]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="actions__delete" type="submit" onclick="return confirm('Supprimer cette catégorie ?')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            @endcan
        </div>

    </div>

    @foreach ($category['children'] as $child)
        @include('categories.partials.category', [
            'category' => $child,
            'level' => $level + 1,
        ])
    @endforeach
</div>
