<x-crud
  title="{{ __('admin/titles.users') }}"
  :storeUrl="route('users_store')"
  :updateUrl="route('users_update', '__ID__')"
  :deleteUrl="route('users_destroy', '__ID__')"
>
  <x-slot name="table">
    <x-tables.users :records="$records" />
  </x-slot>
  <x-slot name="form">
    <x-forms.users :record="$record" />
  </x-slot>
  <x-message />
</x-crud>