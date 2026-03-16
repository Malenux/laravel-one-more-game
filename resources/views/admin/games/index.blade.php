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

<x-modal-filter
    :fields="[
        ['name' => 'title', 'label' => 'Título', 'type' => 'text', 'placeholder' => 'Buscar por título...'],
        ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'placeholder' => 'Buscar por nombre...'],
        ['name' => 'created_at', 'label' => 'Fecha',  'type' => 'date'],
    ]"
/>