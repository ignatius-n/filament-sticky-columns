<?php

declare(strict_types=1);

namespace ZeeshanTariq\FilamentStickyColumns\Concerns;

/**
 * Livewire concern for Filament v4/v5 pages that allow end users to toggle sticky columns.
 *
 * Usage on a List page:
 *
 *   use InteractsWithUserStickyColumns;
 *
 * And on the table:
 *
 *   $table->userStickyColumns()
 *   TextColumn::make('name')->userSticky()
 */
trait InteractsWithUserStickyColumns
{
    /**
     * @var list<string>
     */
    public array $tableUserStickyColumns = [];

    public function bootedInteractsWithUserStickyColumns(): void
    {
        $this->tableUserStickyColumns = array_values(
            array_filter(
                session()->get($this->getTableUserStickySessionKey(), []),
                fn (mixed $name): bool => is_string($name) && $name !== '',
            ),
        );
    }

    /**
     * @param  list<string>  $columns
     */
    public function applyTableUserStickyColumns(array $columns): void
    {
        $this->tableUserStickyColumns = array_values(array_unique(array_filter(
            $columns,
            fn (mixed $name): bool => is_string($name) && $name !== '',
        )));

        session()->put(
            $this->getTableUserStickySessionKey(),
            $this->tableUserStickyColumns,
        );

        $this->js('window.FilamentStickyColumns && window.FilamentStickyColumns.refresh()');
    }

    public function toggleTableUserStickyColumn(string $name): void
    {
        if ($name === '') {
            return;
        }

        if ($this->isTableColumnUserSticky($name)) {
            $this->tableUserStickyColumns = array_values(array_filter(
                $this->tableUserStickyColumns,
                fn (string $column): bool => $column !== $name,
            ));
        } else {
            $this->tableUserStickyColumns[] = $name;
            $this->tableUserStickyColumns = array_values(array_unique($this->tableUserStickyColumns));
        }

        session()->put(
            $this->getTableUserStickySessionKey(),
            $this->tableUserStickyColumns,
        );

        $this->js('window.FilamentStickyColumns && window.FilamentStickyColumns.refresh()');
    }

    public function resetTableUserStickyColumns(): void
    {
        $this->tableUserStickyColumns = [];
        session()->forget($this->getTableUserStickySessionKey());

        $this->js('window.FilamentStickyColumns && window.FilamentStickyColumns.refresh()');
    }

    public function isTableColumnUserSticky(string $name): bool
    {
        return in_array($name, $this->tableUserStickyColumns, true);
    }

    public function getTableUserStickySessionKey(): string
    {
        return 'tables.' . md5(static::class) . '_user_sticky_columns';
    }
}
