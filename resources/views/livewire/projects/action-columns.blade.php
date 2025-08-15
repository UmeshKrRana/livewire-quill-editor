<div class="p-4">

    {{-- Project modal --}}
    <flux:modal.trigger name="project-modal">

        {{-- view  --}}
        <flux:button wire:click="$dispatch('open-project-modal', { mode: 'view', project: {{ $project->id }} })"
            class="cursor-pointer" variant="primary" color="sky" icon="eye" class="cursor-pointer">
        </flux:button>

        {{-- edit  --}}
        <flux:button wire:click="$dispatch('open-project-modal', { mode: 'edit', project: {{ $project->id }} })"
            class="cursor-pointer mx-1" variant="primary" color="blue" icon="pencil" class="cursor-pointer">
        </flux:button>

    </flux:modal.trigger>

    {{-- Delete  --}}
    <flux:modal.trigger name="delete-confirmation-modal">
        <flux:button
            wire:click="$dispatch('confirm-delete', {
                                    id: {{ $project->id }},
                                    dispatchAction: 'delete-project',
                                    modalName: 'delete-confirmation-modal',
                                    heading: 'Delete Project?',
                                    subheading: 'You are about to delete this project: <strong> {{ $project->name }}</strong>. <br/> This action cannot be undone.',
                                    confirmButtonText: 'Delete Project',

                                    })"
            class="cursor-pointer" variant="primary" color="red" icon="trash" class="cursor-pointer">
        </flux:button>
    </flux:modal.trigger>
    </td>
