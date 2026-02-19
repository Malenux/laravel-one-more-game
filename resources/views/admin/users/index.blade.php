<x-crud
  title="{{ __('Usuarios') }}"
>
  <x-slot name="table">
    <x-tables.users :records="$records" />
  </x-slot>
  
  <x-slot name="form">
    <x-forms.users :record="$record" />
  </x-slot>

</x-crud>