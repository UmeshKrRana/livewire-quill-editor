<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Save Email Configurations') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your email configurations which are shown below.') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Flash message component --}}
    <div x-data="{ show: true, message: '', type: '' }" x-init="window.addEventListener('flash', e => {
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
    <form wire:submit="saveConfig" class="space-y-6 grid grid-cols-2 gap-6 rounded shadow p-6">

        {{-- Mail driver --}}
        <div class="form-group">
            <flux:select wire:model="driver" label="Mail Driver" placeholder="None">
                <flux:select.option value="smtp">SMTP</flux:select.option>
                <flux:select.option value="sendmail">Sendmail</flux:select.option>
            </flux:select>
        </div>

        {{-- Mail Host --}}
        <div class="form-group">
            <flux:input wire:model="host" label="Mail Host" placeholder="Ex. smtp.gmail.com" />
        </div>

        {{-- Port --}}
        <div class="form-group">
            <flux:input wire:model="port" label="Mail Port" placeholder="587" />
        </div>

        {{-- Mail Encryption --}}
        <div class="form-group">
            <flux:select wire:model="encryption" label="Encryption" placeholder="None">
                <flux:select.option value="tls">TLS</flux:select.option>
                <flux:select.option value="ssl">SSL</flux:select.option>
            </flux:select>
        </div>

        {{-- User Name --}}
        <div class="form-group">
            <flux:input wire:model="username" label="User Name" placeholder="yourmail@gmail.com" />
        </div>

        {{-- Password --}}
        <div class="form-group">

            @if ($showPasswordInput)
                <flux:input type="password" wire:model="password" label="Password" placeholder="Password" />

                <flux:button size="xs" variant="danger" wire:click="$set('showPasswordInput', false)"
                    class="cursor-pointer mt-2">Cancel</flux:button>
            @else
                {{-- Showing password --}}
                <flux:button size="xs" wire:click="$set('showPasswordInput', true)" variant="filled"
                    class="cursor-pointer">Change Password</flux:button>
            @endif
        </div>

        {{-- From Name --}}
        <div class="form-group">
            <flux:input wire:model="from_name" label="From Name" placeholder="From Name" />
        </div>

        {{-- From Email --}}
        <div class="form-group">
            <flux:input wire:model="from_address" label="From Address" placeholder="no-reply@mail.com" />
        </div>

        {{-- Reply To Name --}}
        <div class="form-group">
            <flux:input wire:model="reply_to_name" label="Reply to Name" placeholder="Reply to Name" />
        </div>

        {{-- Reply to Email --}}
        <div class="form-group">
            <flux:input wire:model="reply_to_address" label="Reply to Address" placeholder="replyemail@mail.com" />
        </div>

        {{-- Timeout --}}
        <div class="form-group">
            <flux:input wire:model="timeout" label="Timeout" placeholder="Ex. 60 (seconds)" />
        </div>

        {{-- Buttons --}}
        <div class="flex jusify-end pt-4">
            <flux:button type="submit" variant="primary" color="indigo" class="cursor-pointer ms-2">Save Configuration
            </flux:button>
        </div>
    </form>
</div>
