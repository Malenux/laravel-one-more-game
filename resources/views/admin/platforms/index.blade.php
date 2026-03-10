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

<x-modal-filter
    :fields="[
        ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'placeholder' => 'Buscar por nombre...'],
        ['name' => 'created_at', 'label' => 'Fecha',  'type' => 'date'],
    ]"
/>