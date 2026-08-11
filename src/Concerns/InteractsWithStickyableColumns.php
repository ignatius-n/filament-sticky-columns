<?php

declare(strict_types=1);

namespace ZeeshanTariq\FilamentStickyColumns\Concerns;

/**
 * Livewire concern for Filament v4/v5 pages that allow end users to toggle sticky columns.
 *
 * Usage on a List page:
 *
 *   use InteractsWithStickyableColumns;
 *
 * And on the table:
 *
 *   $table->stickyableColumns()
 *   TextColumn::make('name')->stickyable()
 */
trait InteractsWithStickyableColumns
{
    /**
     * @var list<string>
     */
    public array $tableStickyableColumns = [];

    public function bootedInteractsWithStickyableColumns(): void
    {
        $this->tableStickyableColumns = array_values(
            array_filter(
                session()->get($this->getTableStickyableSessionKey(), []),
                fn (mixed $name): bool => is_string($name) && $name !== '',
            ),
        );
    }

    /**
     * @param  list<string>  $columns
     */
    public function applyTableStickyableColumns(array $columns): void
    {
        $this->tableStickyableColumns = array_values(array_unique(array_filter(
            $columns,
            fn (mixed $name): bool => is_string($name) && $name !== '',
        )));

        session()->put(
            $this->getTableStickyableSessionKey(),
            $this->tableStickyableColumns,
        );

        $this->js('window.FilamentStickyColumns && window.FilamentStickyColumns.refresh()');
    }

    public function toggleTableStickyableColumn(string $name): void
    {
        if ($name === '') {
            return;
        }

        if ($this->isTableColumnStickyable($name)) {
            $this->tableStickyableColumns = array_values(array_filter(
                $this->tableStickyableColumns,
                fn (string $column): bool => $column !== $name,
            ));
        } else {
            $this->tableStickyableColumns[] = $name;
            $this->tableStickyableColumns = array_values(array_unique($this->tableStickyableColumns));
        }

        session()->put(
            $this->getTableStickyableSessionKey(),
            $this->tableStickyableColumns,
        );

        $this->js('window.FilamentStickyColumns && window.FilamentStickyColumns.refresh()');
    }

    public function resetTableStickyableColumns(): void
    {
        $this->tableStickyableColumns = [];
        session()->forget($this->getTableStickyableSessionKey());

        $this->js('window.FilamentStickyColumns && window.FilamentStickyColumns.refresh()');
    }

    public function isTableColumnStickyable(string $name): bool
    {
        return in_array($name, $this->tableStickyableColumns, true);
    }

    public function getTableStickyableSessionKey(): string
    {
        return 'tables.' . md5(static::class) . '_stickyable_columns';
    }
}
