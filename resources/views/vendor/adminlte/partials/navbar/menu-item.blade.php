@inject('menuItemHelper', \JeroenNoten\LaravelAdminLte\Helpers\MenuItemHelper::class)

{{-- @if ($menuItemHelper->isSearchBar($item))

    {{-- Search form -
    @include('adminlte::partials.navbar.menu-item-search-form')

@else --}}

@if ($menuItemHelper->isSubmenu($item))

    {{-- Dropdown menu --}}
    @include('adminlte::partials.navbar.menu-item-dropdown-menu')

@elseif ($menuItemHelper->isLink($item))

    {{-- Link --}}
    @include('adminlte::partials.navbar.menu-item-link')

@endif
