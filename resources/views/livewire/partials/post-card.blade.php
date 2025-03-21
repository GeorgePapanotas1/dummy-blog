<div class="shadow-lg rounded-lg p-5 card">
    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
        {{ $post->title }}
    </h3>

    <livewire:partials.post-meta :post="$post" />

    <div class="mt-3">
        <p class="text-gray-700 dark:text-gray-300 text-sm truncate">
            {{ Str::limit($post->content, 50) }}
        </p>
    </div>

    <div class="mt-4 flex justify-end items-center">
        <a href="{{ route('public.posts.show', $post->id) }}">
            <flux:button variant="primary">Read More</flux:button>
        </a>
    </div>
</div>
