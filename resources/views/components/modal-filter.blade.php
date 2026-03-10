@props(['fields' => []])

<div class="overlay" id="modal-filter">
  <div class="filter-modal">

    <div class="filter-modal__header">
      <h2>Filtrar</h2>
    </div>

    <div class="filter-modal__body">

      <div class="filter-modal__fields">
        @foreach($fields as $field)
          <div class="filter-modal__field">
            <label for="filter-{{ $field['name'] }}">{{ $field['label'] }}</label>

            @if(($field['type'] ?? 'text') === 'select')
              <select id="filter-{{ $field['name'] }}" name="{{ $field['name'] }}" data-filter>
                <option value="">-- Todos --</option>
                @foreach($field['options'] as $val => $text)
                  <option value="{{ $val }}">{{ $text }}</option>
                @endforeach
              </select>

            @elseif(($field['type'] ?? 'text') === 'date')
              <input id="filter-{{ $field['name'] }}" type="date" name="{{ $field['name'] }}" data-filter />

            @else
              <input
                id="filter-{{ $field['name'] }}"
                type="text"
                name="{{ $field['name'] }}"
                data-filter
                placeholder="{{ $field['placeholder'] ?? '' }}"
              />
            @endif
          </div>
        @endforeach
      </div>

      <div class="filter-modal__actions">

        <button type="button" class="filter-modal__btn filter-modal__btn--confirm">
          <span>Aplicar</span>
        </button>

        <button type="button" class="filter-modal__btn filter-modal__btn--cancel">
            <span>Cancelar</span>
        </button>

      </div>

    </div>

  </div>
</div>