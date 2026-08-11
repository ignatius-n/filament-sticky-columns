@php
    /** @var list<array{name: string, label: string, isSticky: bool}> $columns */
    $columns ??= [];
@endphp

<x-filament::dropdown
    placement="bottom-end"
    shift
    :flip="false"
    width="xs"
    class="fi-ta-col-manager-dropdown fi-ta-sticky-manager-dropdown"
>
    <x-slot name="trigger">
        <x-filament::icon-button
            color="gray"
            icon="heroicon-s-bookmark"
            label="Sticky columns"
            class="fi-ta-sticky-manager-trigger"
        />
    </x-slot>

    @include('filament-sticky-columns::components.user-sticky-panel', [
        'columns' => $columns,
    ])
</x-filament::dropdown>
