    <div class="min-h-screen">

        {{-- Quill CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

        <form wire:submit="savePost" class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">
                    Create Blog Post</flux:heading>
                <flux:text class="mt-2">Add a new blog post using the form below.</flux:text>
            </div>

            {{-- Post Title --}}
            <div class="form-group">
                <flux:input :disabled="$isView" wire:model="title" label="Post Title"
                    placeholder="Enter post title" />
            </div>

            {{-- Description --}}
            <div class="form-group" wire:ignore>
                <div id="editor" style="min-height: 200px;"></div>
            </div>

            {{-- Buttons --}}
            <div class="flex jusify-end pt-4">
                <flux:spacer />

                <flux:button href="{{ route('posts.index') }}" wire:navigate variant="ghost" class="cursor-pointer">
                    Cancel</flux:button>

                @if (!$isView)
                    <flux:button type="submit" variant="primary" color="indigo" class="cursor-pointer ms-2">
                        Save Post
                    </flux:button>
                @endif
            </div>
        </form>

        @push('scripts')
            {{-- Quill JS --}}
            <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

            <script>
                let quill;
                document.addEventListener('livewire:navigated', () => {

                    console.log('load')

                    const toolbarOptions = [
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                        ['blockquote', 'code-block'],

                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }, {
                            'list': 'check'
                        }],
                        [{
                            'script': 'sub'
                        }, {
                            'script': 'super'
                        }], // superscript/subscript
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }], // outdent/indent
                        [{
                            'direction': 'rtl'
                        }], // text direction

                        [{
                            'size': ['small', false, 'large', 'huge']
                        }], // custom dropdown
                        [{
                            'color': []
                        }, {
                            'background': []
                        }], // dropdown with defaults from theme
                        [{
                            'font': []
                        }],
                        [{
                            'align': []
                        }],

                        ['link', 'image', 'video', 'formula'],

                        ['clean'] // remove formatting button
                    ];

                    quill = new Quill('#editor', {
                        theme: 'snow',
                        readOnly: @json($isView),
                        modules: {
                            toolbar: {
                                container: toolbarOptions,
                                handlers: {
                                    image: function() {
                                        selectLocalImage();
                                    }
                                }
                            }
                        }
                    });

                    // Text change
                    quill.on('text-change', function() {
                        @this.set('description', quill.root.innerHTML);
                    });
                });

                // Clear quil lte
                window.addEventListener('clear-quill', () => {
                    if (quill) quill.setText('');
                });

                // Listen for populate
                window.addEventListener('populate-quill', event => {
                    if (quill) {
                        quill.root.innerHTML = event.detail.description || '';
                    } else {
                        setTimeout(() => {
                            if (quill) quill.root.innerHTML = event.detail.description || '';
                        }, 300);
                    }
                });

                // Select local image
                function selectLocalImage() {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.click();

                    input.onchange = () => {
                        const file = input.files[0];
                        if (file) {
                            uploadImage(file);
                        }
                    };
                }

                // Upload image
                function uploadImage(file) {
                    const formData = new FormData();
                    formData.append('image', file);

                    fetch("{{ route('livewire.upload-image') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(result => {
                            const range = quill.getSelection();
                            quill.insertEmbed(range.index, 'image', result.url);
                        })
                        .catch(err => console.error(err));
                }
            </script>
        @endpush
    </div>
