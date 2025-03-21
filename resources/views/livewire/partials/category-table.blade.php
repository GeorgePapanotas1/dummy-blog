<div class="dark:bg-[#161615] shadow rounded-lg">
    <table class="w-full border-collapse border border-gray-300">
        <thead>
        <tr class="dark:bg-[#272727]">
            <th class="p-2 text-left">#</th>
            <th class="p-2 text-left cursor-pointer" wire:click="sort('name')">
                Name
                @if ($sortBy === 'name')
                    <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                @endif
            </th>
            <th class="p-2 text-left cursor-pointer" wire:click="sort('created_at')">
                Creation Date
                @if ($sortBy === 'created_at')
                    <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                @endif
            </th>
            <th class="p-2 text-left">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($categories as $index => $category)
            <tr class="border-t">
                <td class="p-2">{{ $category->id }}</td>
                <td class="p-2">{{ $category->name }}</td>
                <td class="p-2">{{ $category->created_at->diffForHumans() }}</td>
                <td class="p-2">
                    <flux:button icon="pencil-square" class="mr-3" wire:click="dispatch('editCategory', [{{ $category->id }}])">
                    </flux:button>

                    <flux:button variant="danger" icon="trash" wire:click="dispatch('confirmDelete', [{{ $category->id }}])">
                    </flux:button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $categories->links() }}
    </div>
</div>
