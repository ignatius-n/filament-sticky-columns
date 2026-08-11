<?php

declare(strict_types=1);

namespace ZeeshanTariq\FilamentStickyColumns\Support;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;

/**
 * @internal
 */
final class UserStickyManager
{
    /**
     * @return list<array{name: string, label: string, isSticky: bool}>
     */
    public static function optionsForLivewire(object $livewire): array
    {
        if (! method_exists($livewire, 'getTable') || ! method_exists($livewire, 'isTableColumnUserSticky')) {
            return [];
        }

        try {
            $table = $livewire->getTable();
        } catch (\Throwable) {
            return [];
        }

        if (! $table instanceof Table) {
            return [];
        }

        $options = [];

        foreach ($table->getColumns() as $column) {
            if (! $column instanceof Column) {
                continue;
            }

            if (! UserStickyRegistry::isUserStickyable($column)) {
                continue;
            }

            if (method_exists($column, 'isHidden') && $column->isHidden()) {
                continue;
            }

            if (method_exists($column, 'isToggledHidden') && $column->isToggledHidden()) {
                continue;
            }

            $name = $column->getName();

            $options[] = [
                'name' => $name,
                'label' => trim(strip_tags((string) $column->getLabel())) ?: $name,
                'isSticky' => $livewire->isTableColumnUserSticky($name),
            ];
        }

        return $options;
    }
}
