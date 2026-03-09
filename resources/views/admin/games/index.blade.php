<x-crud
  title="{{ __('Juegos') }}"
>
  <x-slot name="table">
    <x-tables.games :records="$records" />
  </x-slot>

  <x-slot name="form">
    <x-forms.games :record="$record" />
  </x-slot>

</x-crud>