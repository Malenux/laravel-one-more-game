@props(['title', 'storeUrl', 'updateUrl', 'deleteUrl'])

<x-layouts.admin :title="$title">

<div class="admin-panel"
     data-store-url="{{ $storeUrl }}"
     data-update-url="{{ $updateUrl }}"
     data-delete-url="{{ $deleteUrl }}">

    <div class="admin-panel__header">
        <div class="header__title">
            <h2>{{ $title }}</h2>
        </div>
    </div>

    <div class="admin-panel__content">

        <div class="admin-panel__table">
            {{ $table }}
        </div>

        <div class="admin-panel__form">
            {{ $form }}
        </div>

    </div>

</div>

</x-layouts.admin>
