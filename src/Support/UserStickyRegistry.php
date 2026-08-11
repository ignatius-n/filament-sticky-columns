<?php

declare(strict_types=1);

namespace ZeeshanTariq\FilamentStickyColumns\Support;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use WeakMap;

/**
 * Tracks user-toggleable sticky columns, forced sticky columns, and enabled tables.
 *
 * @internal
 */
final class UserStickyRegistry
{
    /** @var WeakMap<Column, string>|null side: left|right */
    private static ?WeakMap $userStickyable = null;

    /** @var WeakMap<Column, string>|null side: left|right */
    private static ?WeakMap $forcedSticky = null;

    /** @var WeakMap<Table, bool>|null */
    private static ?WeakMap $enabledTables = null;

    public static function markUserStickyable(Column $column, string $side = 'left'): void
    {
        self::$userStickyable ??= new WeakMap;
        self::$userStickyable[$column] = $side === 'right' ? 'right' : 'left';
    }

    public static function markForced(Column $column, string $side = 'left'): void
    {
        self::$forcedSticky ??= new WeakMap;
        self::$forcedSticky[$column] = $side === 'right' ? 'right' : 'left';
    }

    public static function userSideFor(Column $column): ?string
    {
        return self::$userStickyable[$column] ?? null;
    }

    public static function forcedSideFor(Column $column): ?string
    {
        return self::$forcedSticky[$column] ?? null;
    }

    public static function isUserStickyable(Column $column): bool
    {
        return self::userSideFor($column) !== null;
    }

    public static function isForced(Column $column): bool
    {
        if (self::forcedSideFor($column) !== null) {
            return true;
        }

        return method_exists($column, 'isSticky') && $column->isSticky();
    }

    public static function enableTable(Table $table): void
    {
        self::$enabledTables ??= new WeakMap;
        self::$enabledTables[$table] = true;
    }

    public static function isTableEnabled(Table $table): bool
    {
        return (bool) (self::$enabledTables[$table] ?? false);
    }
}
