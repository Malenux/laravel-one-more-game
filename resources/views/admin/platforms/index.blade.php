<x-crud
  title="{{ __('Plataformas') }}"
>
  <x-slot name="table">
    <x-tables.platforms :records="$records" />
  </x-slot>

  <x-slot name="form">
    <x-forms.platforms :record="$record" />
  </x-slot>

</x-crud>