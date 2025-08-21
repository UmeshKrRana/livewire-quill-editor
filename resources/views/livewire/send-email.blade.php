<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Compose Email') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Send email to your receipients using the form below.') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Flash message component --}}
    <div x-data="{ show: false, message: '', type: '' }" x-init="window.addEventListener('flash', e => {
        const data = e.detail[0];
        message = data.message;
        type = data.type;
        show = true;
        setTimeout(() => show = false, 4000);

    });" x-show="show" x-transition
        class="fixed top-4 right-4 px-4 py-2 rounded shadow-lg text-white z-50"
        :class="{
            'bg-emerald-600': type === 'success',
            'bg-red-600': type === 'error',
        }"
        style="display: none;">

        <span x-text="message"></span>
    </div>

    {{-- Form --}}
    <form wire:submit="send" class="space-y-6 grid grid-cols-2 gap-6 rounded shadow p-6">

        {{-- To Email --}}
        <div class="form-group">
            <flux:input wire:model="to" label="To (Email Address)" placeholder="mailaddress@mail.com" />
        </div>

        {{-- Subject --}}
        <div class="form-group">
            <flux:input wire:model="subject" label="Subject" placeholder="Subject Line" />
        </div>

        {{-- Message --}}
        <div class="form-group">
            <flux:textarea wire:model="message" label="Message Body" placeholder="Your Message..." />
        </div>

        {{-- File Attachment --}}
        <div class="form-group">
            <flux:input type="file" wire:model="attachment" label="Attachment (optional)" />
        </div>

        {{-- Buttons --}}
        <div class="flex jusify-end pt-4">
            <flux:button type="submit" variant="primary" color="indigo" class="cursor-pointer ms-2">Send Email
            </flux:button>
        </div>
    </form>
</div>
