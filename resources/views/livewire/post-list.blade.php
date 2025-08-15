<div class="p-4">

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Posts Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create and manage your blog posts.') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- button section --}}
    <div class="text-end mb-4">
        <flux:button wire:navigate href="{{ route('posts.create') }}" variant="primary" color="indigo" icon="plus-circle"
            class="cursor-pointer">Add Post
        </flux:button>
    </div>

    {{-- Table for listing --}}
    <div class="overflow-x-auto border rounded-xl shadow-md">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold border-b">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Title</th>
                    <th class="p-4">Created At</th>
                    <th class="p-4 text-center w-40">Actions </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($posts as $post)
                    <tr class="hover:bg-gray-50 transition border-t">
                        <td class="p-4">{{ $post->id }}</td>
                        <td class="p-4">{{ $post->title }}</td>
                        <td class="p-4">{{ $post->created_at->format('d-m-Y') }}</td>

                        {{-- Actions --}}
                        <td class="p-4">
                            {{-- view  --}}
                            <flux:button href="{{ route('posts.detail', ['mode' => 'view', 'id' => $post->id]) }}"
                                class="cursor-pointer" variant="primary" color="sky" icon="eye"
                                class="cursor-pointer">
                            </flux:button>

                            {{-- edit  --}}
                            <flux:button href="{{ route('posts.detail', ['mode' => 'edit', 'id' => $post->id]) }}"
                                class="cursor-pointer mx-1" variant="primary" color="blue" icon="pencil"
                                class="cursor-pointer">
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center">
                            <flux:text class="flex items-center justify-center text-red-500">
                                <flux:icon.exclamation-triangle class="mr-2" /> No projects found!
                            </flux:text>
                        </td>

                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
