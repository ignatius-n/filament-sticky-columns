@php
    /** @var list<array{name: string, label: string, isSticky: bool}> $columns */
    $columns ??= [];
@endphp

<div class="fi-ta-col-manager fi-ta-sticky-manager">
    <div class="fi-ta-col-manager-header">
        <h3 class="fi-ta-col-manager-heading">
            Sticky columns
        </h3>

        <x-filament::link
            color="danger"
            tag="button"
            wire:click="resetTableUserStickyColumns"
            wire:loading.attr="disabled"
            wire:target="resetTableUserStickyColumns,toggleTableUserStickyColumn"
        >
            Reset
        </x-filament::link>
    </div>

    @if (count($columns))
        <div class="fi-ta-col-manager-items">
            @foreach ($columns as $column)
                <div
                    class="fi-ta-col-manager-item"
                    wire:key="user-sticky-{{ $column['name'] }}"
                >
                    <label class="fi-ta-col-manager-label">
                        {{--
                            Bind checked via Alpine/$wire so Livewire morph
                            does not leave the visual checkbox out of sync
                            (same pattern as Filament's column manager).
                        --}}
                        <input
                            type="checkbox"
                            class="fi-checkbox-input"
                            x-bind:checked="($wire.tableUserStickyColumns || []).includes(@js($column['name']))"
                            x-on:click.prevent="$wire.toggleTableUserStickyColumn(@js($column['name']))"
                            wire:loading.attr="disabled"
                            wire:target="toggleTableUserStickyColumn,resetTableUserStickyColumns"
                        />

                        <span>{{ $column['label'] }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    @else
        <p class="fi-ta-sticky-manager-empty">
            No sticky columns available.
        </p>
    @endif
</div>
