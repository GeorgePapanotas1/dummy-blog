<div class="mx-auto p-4 bg-white dark:bg-[#161615] shadow-md rounded">
    <h2 class="text-xl font-bold mb-4">Your Posts</h2>

    @if (session()->has('success'))
        <div class="bg-green-200 text-green-700 p-2 mb-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('fail'))
        <div class="bg-red-200 text-red-700 p-2 mb-3 rounded">
            {{ session('fail') }}
        </div>
    @endif

    <div class="mt-5">
        <flux:button wire:click="openCreateModal()" icon="plus">Create</flux:button>
    </div>

    <div class="mt-5">
        <livewire:partials.post-table />
    </div>

    <!-- Create Post Modal -->
    <flux:modal name="create-post" variant="flyout" wire:model.self="showCreateModal">
        <div class="space-y-6">
            <flux:heading size="lg">Create Post</flux:heading>

            <form wire:submit.prevent="createPost">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input wire:model="title" />
                    <flux:error name="title" />
                </flux:field>

                <flux:field class="mt-3">
                    <flux:label>Content</flux:label>
                    <flux:textarea wire:model="content"></flux:textarea>
                    <flux:error name="content" />
                </flux:field>

                <flux:field class="mt-3">
                    <flux:label>Category</flux:label>
                    <flux:select wire:model="category_id">
                        <option value="">Select a Category</option>
                        @foreach ($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="category_id" />
                </flux:field>

                <div class="flex mt-3">
                    <flux:spacer />
                    <flux:button variant="primary" type="submit" class="mt-5">Submit</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Post Modal -->
    <flux:modal name="edit-post" variant="flyout" wire:model.self="showEditModal">
        <div class="space-y-6">
            <flux:heading size="lg">Edit Post</flux:heading>

            <form wire:submit.prevent="updatePost">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input wire:model="title" />
                    <flux:error name="title" />
                </flux:field>

                <flux:field class="mt-3">
                    <flux:label>Content</flux:label>
                    <flux:textarea wire:model="content"></flux:textarea>
                    <flux:error name="content" />
                </flux:field>

                <flux:field class="mt-3">
                    <flux:label>Category</flux:label>
                    <flux:select wire:model="category_id">
                        <option value="">Select a Category</option>
                        @foreach ($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="category_id" />
                </flux:field>

                <div class="flex mt-3" >
                    <flux:spacer />
                    <flux:button variant="primary" type="submit" class="mt-5">Update</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>

<script>

    document.addEventListener('close-modal', () => {
        Flux.modal('create-post').close()
    });

    document.addEventListener('close-edit-modal', () => {
        Flux.modal('edit-post').close()
    });

    document.addEventListener('confirmDeletePost', event => {
        if (confirm("Are you sure you want to delete this post?")) {
            Livewire.dispatch('deletePost', event.detail);
        }
    });
</script>
