<x-crud
  title="{{ __('Clientes') }}"
>
  <x-slot name="table">
    <x-tables.customers :records="$records" />
  </x-slot>

  <x-slot name="form">
    <x-forms.customers :record="$record" />
  </x-slot>

</x-crud>