<div class="p-4 bg-white dark:bg-[#161615] shadow-md rounded">
    <!-- Search & Filters -->
    <div class="flex items-center gap-4 mb-6 justify-center">
        <!-- Search -->
        <flux:input type="text" wire:model.live.debounce.300ms="search" placeholder="Search posts..." />

        <!-- Category Filter -->
        <flux:select wire:model.live="categoryFilter">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </flux:select>

        <flux:select wire:model.live="userFilter">
            <option value="">All Users</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </flux:select>

    </div>

    <!-- Post Grid -->
    @if(count($posts))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($posts as $post)
            <livewire:partials.post-card :post="$post" :key="$post->id" />
        @endforeach
    </div>
    @else
        <div class="text-center">No posts found</div>
    @endif

    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $posts->links() }}
    </div>
</div>
