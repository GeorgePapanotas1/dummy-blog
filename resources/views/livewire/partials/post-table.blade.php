<div class="dark:bg-[#161615] shadow rounded-lg">
    <table class="w-full border-collapse border border-gray-300">
        <thead>
        <tr class="dark:bg-[#272727]">
            <th class="p-2 text-left">#</th>
            <th class="p-2 text-left cursor-pointer" wire:click="sort('name')">
                Title
                @if ($sortBy === 'name')
                    <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                @endif
            </th>
            <th class="p-2 text-left">Content</th>
            <th class="p-2 text-left cursor-pointer" wire:click="sort('category_id')">
                Category
            </th>
            <th class="p-2 text-left cursor-pointer" wire:click="sort('comments_count')">
                Comments
            </th>
            <th class="p-2 text-left cursor-pointer" wire:click="sort('created_at')">
                Created At
                @if ($sortBy === 'created_at')
                    <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                @endif
            </th>
            <th class="p-2 text-left">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($posts as $index => $post)
            <tr class="border-t">
                <td class="p-2">{{ $index + 1 }}</td>
                <td class="p-2">{{ $post->title }}</td>
                <td class="p-2 truncate max-w-xs">{{ Str::limit($post->content, 50) }}</td>
                <td class="p-2">{{ $post->category->name ?? 'Uncategorized' }}</td>
                <td class="p-2">{{ $post->comments->count() ?? '-' }}</td>
                <td class="p-2">{{ $post->created_at->format('Y-m-d') }}</td>
                <td class="p-2">
                @if($post->user_id === auth()->user()->id)
                    <flux:button class="mr-3" icon="pencil-square" wire:click="dispatch('editPost', [{{ $post }}])">
                    </flux:button>

                    <flux:button variant="danger" icon="trash" wire:click="dispatch('confirmDeletePost', [{{ $post }}])">
                    </flux:button>
                @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $posts->links() }}
    </div>
</div>
