<div class="flex justify-between items-center w-full">
    <div>
        <div class="text-sm text-gray-600 dark:text-gray-400 flex gap-2">
            <flux:icon.calendar-days variant="micro" /> {{ $post->created_at->format('M d, Y') }}
        </div>
        <div class="text-sm text-gray-600 dark:text-gray-400 flex gap-2">
            <flux:icon.user variant="micro" /> {{ $post->user->name }}
        </div>
    </div>
    <div>
        <div class="text-sm text-gray-600 dark:text-gray-400 flex gap-2">
            <flux:icon.tag variant="micro" /> {{ $post->category->name ?? 'Uncategorized' }}
        </div>
        <div class="text-sm text-gray-600 dark:text-gray-400 flex gap-2">
            <flux:icon.chat-bubble-bottom-center variant="micro" /> {{ $post->comments->count() ?? '0' }}
        </div>
    </div>
</div>
