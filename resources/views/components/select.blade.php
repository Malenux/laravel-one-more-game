{{-- @props(['options' => [], 'selected' => '', 'name', 'id' => null, ])

<select name="{{ $name }}" id="{{ $id ?? $name }}" {{ $attributes->merge(['class' => 'form-element-input']) }}
>
    @foreach ($options as $value => $label)
        @php $val = is_int($value) ? $label : $value; @endphp
        <option value="{{ $val }}" {{ $selected == $val ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select> --}}