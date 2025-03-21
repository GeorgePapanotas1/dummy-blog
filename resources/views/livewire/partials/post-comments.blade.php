<div class="mt-8 p-6 bg-gray-100 dark:bg-gray-800 rounded-lg" wire:poll.5s>
    <h3 class="text-xl font-bold mb-4">Comments</h3>

    <!-- Display Comments -->
    <div class="space-y-4">
        @foreach($comments as $comment)
            <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
                <p class="text-sm text-gray-500">{{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}</p>
                <p class="text-gray-900 dark:text-gray-200">{{ $comment->comment }}</p>
            </div>
        @endforeach
    </div>

    <!-- Add a Comment -->
    @auth
        @if (session()->has('fail'))
            <div class="bg-red-200 text-red-700 p-2 mb-3 rounded">
                {{ session('fail') }}
            </div>
        @endif

        <div class="mt-6">
            <textarea wire:model="content" class="w-full p-3 border rounded" placeholder="Write a comment..."></textarea>
            <flux:button wire:click="addComment" class="mt-2">Post Comment</flux:button>
        </div>
    @else
        <p class="text-gray-500 text-sm mt-4">Log in to leave a comment.</p>
    @endauth
</div>
