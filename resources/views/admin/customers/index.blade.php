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

<x-modal-filter
    :fields="[
        ['name' => 'name',       'label' => 'Nombre', 'type' => 'text', 'placeholder' => 'Buscar por nombre...'],
        ['name' => 'email',      'label' => 'Email',  'type' => 'text', 'placeholder' => 'Buscar por email...'],
        ['name' => 'created_at', 'label' => 'Fecha',  'type' => 'date'],
    ]"
/>