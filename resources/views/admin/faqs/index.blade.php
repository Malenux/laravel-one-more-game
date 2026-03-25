<x-crud
  title="{{ __('Preguntas Frecuentes') }}"
>
  <x-slot name="table">
    <x-tables.faqs :records="$records" />
  </x-slot>

  <x-slot name="form">
    <x-forms.faqs :record="$record" />
  </x-slot>

</x-crud>

<x-modal-filter
    :fields="[
        ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'placeholder' => 'Buscar por nombre...'],
        ['name' => 'question', 'label' => 'Pregunta', 'type' => 'text', 'placeholder' => 'Buscar por pregunta...'],
        ['name' => 'answer', 'label' => 'Respuesta', 'type' => 'text', 'placeholder' => 'Buscar por respuesta...'],
        ['name' => 'created_at', 'label' => 'Fecha',  'type' => 'date'],
    ]"
/>