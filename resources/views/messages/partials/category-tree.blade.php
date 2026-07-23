<div
    class="messages-tree__category"
    style="--category-level: {{ $level }};"
>
    <div class="messages-tree__category-row">
        @if ($category->children->isNotEmpty())
            <span
                class="messages-tree__arrow"
                aria-hidden="true"
            >
                ▾
            </span>
        @else
            <span
                class="messages-tree__arrow messages-tree__arrow--empty"
                aria-hidden="true"
            ></span>
        @endif

        <span
            class="messages-tree__folder"
            aria-hidden="true"
        >
            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M3 6.5A2.5 2.5 0 0 1 5.5 4H9l2 2h7.5A2.5 2.5 0 0 1 21 8.5v9A2.5 2.5 0 0 1 18.5 20h-13A2.5 2.5 0 0 1 3 17.5z"/>
            </svg>
        </span>

        <span class="messages-tree__category-label">
            {{ $category->label }}
        </span>
    </div>

    @foreach ($category->messages as $message)
        <div
            class="messages-tree__message"
            style="--message-level: {{ $level + 1 }};"
        >
            <span
                class="messages-tree__message-icon"
                aria-hidden="true"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M8 18 4 21v-5a7 7 0 0 1-2-5c0-4.4 4-8 9-8s9 3.6 9 8-4 8-9 8a11 11 0 0 1-3-.4"/>
                    <path d="M8 11h.01M12 11h.01M16 11h.01"/>
                </svg>
            </span>

            <span class="messages-tree__message-label">
                {{ $message->label }}
            </span>

            <div class="messages-tree__actions">
                <a
                    href="{{ route('messages.edit', [
                        'project' => $project,
                        'message' => $message,
                    ]) }}"
                    class="messages-tree__action"
                    title="Modifier {{ $message->label }}"
                    aria-label="Modifier {{ $message->label }}"
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4z"/>
                    </svg>
                </a>

                {{-- <form
                    method="POST"
                    action="{{ route('messages.destroy', [
                        'project' => $project,
                        'message' => $message,
                    ]) }}"
                    class="messages-tree__delete-form"
                    onsubmit="return confirm('Supprimer le message « {{ addslashes($message->label) }} » ?')"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="messages-tree__action messages-tree__action--delete"
                        title="Supprimer {{ $message->label }}"
                        aria-label="Supprimer {{ $message->label }}"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M3 6h18"/>
                            <path d="M8 6V4h8v2"/>
                            <path d="M19 6 18 20H6L5 6"/>
                            <path d="M10 11v5M14 11v5"/>
                        </svg>
                    </button>
                </form> --}}
            </div>
        </div>
    @endforeach

    @foreach ($category->children as $child)
        @include('messages.partials.category-tree', [
            'category' => $child,
            'project' => $project,
            'level' => $level + 1,
        ])
    @endforeach
</div>
