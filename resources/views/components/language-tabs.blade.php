@props(['tabs' => []])

<div class="tabs">

  @foreach($tabs as $tab)
    <div class="tab-language {{ $loop->first ? 'active' : '' }}" data-tab="{{ $tab->label }}">
      <button type="button">{{ $tab->label }}</button>
    </div>
  @endforeach

</div>