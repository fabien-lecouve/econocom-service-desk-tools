<div class="tree__item">

    {{-- Catégorie --}}
    <div class="tree__row tree__row--category">

        <div class="tree__label" style="padding-left: {{ $level * 2 }}rem;">
            <div class="icon icon--square icon-label">
                <i class="fa-solid fa-folder"></i>
            </div>
            <span>
                {{ $category->label }}
            </span>
        </div>

    </div>


    {{-- Messages de la catégorie --}}
    @foreach ($category->messages as $message)
        <div class="tree__row tree__row--message">

            <div class="tree__label" style="padding-left: {{ ($level + 1) * 2 }}rem;">
                <div class="icon icon--square icon-label">
                    <i class="fa-regular fa-comment"></i>
                </div>
                <span>
                    {{ $message->label }}
                </span>
            </div>

            <div class="tree__code">
                {{ $message->code }}
            </div>

            <div class="actions">

                @can('update', $category)
                    <a class="actions__edit"
                        href="{{ route('projects.messages.edit', [
                            'project' => $project,
                            'message' => $message,
                        ]) }}">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                @endcan

                @can('delete', $message)
                    <form
                        action="{{ route('projects.messages.destroy', [
                            'project' => $project,
                            'message' => $message,
                        ]) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="actions__delete" type="submit" onclick="return confirm('Supprimer ce message ?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </form>
                @endcan
            </div>

        </div>
    @endforeach


    {{-- Sous-catégories --}}
    @foreach ($category->children as $child)
        @include('messages.partials.category-tree', [
            'category' => $child,
            'project' => $project,
            'level' => $level + 1,
        ])
    @endforeach

</div>
