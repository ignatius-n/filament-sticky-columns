# Changelog

All notable changes to `zeeshantariq/filament-sticky-columns` will be documented here.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).
This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.2.0] — 2026-08-11

### Changed
- Renamed the user-toggle API to Filament-style names: `->stickyable()`, `$table->stickyableColumns()`, and `InteractsWithStickyableColumns` (replaces `userSticky` / `userStickyColumns` / `InteractsWithUserStickyColumns` from v1.1.0).

### Docs
- Highlight stickyable columns (Filament v4 & v5) at the top of the README with a full usage section.

## [1.1.0] — 2026-08-11

### Added
- Sticky table headers now show a small pin icon before the column label.
- **Filament v4 & v5:** end users can toggle sticky columns via a toolbar dropdown (`->userSticky()` + `$table->userStickyColumns()` + `InteractsWithUserStickyColumns` on the List page), with live toggles, Reset, and a solid bookmark trigger icon. Hidden/toggleable-off columns are excluded. No-op on Filament v3. Renamed in [1.2.0](#120--2026-08-11).

## [1.0.8] — 2026-06-20

### Fixed
- Summary row totals no longer sit under sticky columns when scrolling horizontally. Sticky styles now follow logical column indices (respecting `colspan`) and are skipped on merged summary heading cells.

## [1.0.4] — 2026-04-16

### Fixed
- Support Filament v4/v5 horizontal scroll wrapper `.fi-ta-content-ctn.fi-fixed-positioning-context` in addition to `.fi-ta-table-wrapper`.
- Auto-detect the nearest horizontal scroll parent and mark it with `data-sticky-wrapper` when hook classes are missing.
- Publishable `resources/dist/filament-sticky-columns.css` to ensure `php artisan filament:assets` works in consuming projects.

## [1.0.0] — 2025-04-11

### Added
- `HasStickyColumn` trait with `->sticky()`, `->stickyRight()`, `->stickyZIndex()` fluent methods
- `StickyColumn` drop-in TextColumn subclass, sticky LEFT by default
- `->right()` shorthand alias on `StickyColumn`
- Auto-computed column offsets via JS `offsetWidth` measurement
- Manual offset override via `->sticky(offset: 60)`
- Scroll-triggered directional shadows (`sticky-shadow-active` CSS class)
- Dark mode support via Filament CSS custom properties
- Filament v3, v4, v5 compatibility
- Livewire v3 support (`Livewire.hook('commit', ...)`)
- Livewire v4 support (`livewire:navigated`, `livewire:update` events)
- Alpine.js re-initialisation support
- `window.FilamentStickyColumns.refresh()` for manual re-trigger
- Config file: `z_index`, `background`, `shadow`, `shadow_color`
- Pest test suite
