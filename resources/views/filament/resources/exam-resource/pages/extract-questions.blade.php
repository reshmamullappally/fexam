<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <x-filament::button type="submit" color="primary">
            Save Questions
        </x-filament::button>
    </form>
</x-filament::page>
