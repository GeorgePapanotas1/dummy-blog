<div class="mx-auto p-4 bg-white dark:bg-[#161615] shadow-md rounded">
    <h2 class="text-xl font-bold mb-4">Create Post Category</h2>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="bg-green-200 text-green-700 p-2 mb-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-5">
        <flux:button wire:click="openCreateModal()" icon="plus">Create</flux:button>
    </div>
    <div class="mt-5">
        <livewire:partials.category-table />
    </div>

    <flux:modal name="edit-profile" variant="flyout" wire:model.self="showCreateModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Create category</flux:heading>
                <flux:subheading>Create a new category for the posts</flux:subheading>
            </div>

            <form wire:submit.prevent="createCategory">
                <flux:field>
                    <flux:label>Name</flux:label>

                    <flux:input wire:model="name" />

                    <flux:error name="name" />
                </flux:field>

                <div class="flex">
                    <flux:spacer />

                    <flux:button variant="primary" type="submit" class="mt-5">Submit</flux:button>
                </div>
            </form>


        </div>
    </flux:modal>

    <flux:modal name="edit-category" variant="flyout" wire:model.self="showEditModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit category</flux:heading>
                <flux:subheading>Modify the category details</flux:subheading>
            </div>

            <form wire:submit.prevent="updateCategory">
                <flux:field>
                    <flux:label>Name</flux:label>
                    <flux:input wire:model="name" />
                    <flux:error name="name" />
                </flux:field>

                <div class="flex">
                    <flux:spacer />
                    <flux:button variant="primary" type="submit" class="mt-5">Update</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

</div>

<script>

    document.addEventListener('close-modal', () => {
        Flux.modal('edit-profile').close()
    });

    document.addEventListener('close-edit-modal', () => {
        Flux.modal('edit-category').close()
    });

    document.addEventListener('confirmDelete', event => {
        if (confirm("Are you sure you want to delete this category?")) {
            Livewire.dispatch('deleteCategory', event.detail);
        }
    });
</script>
