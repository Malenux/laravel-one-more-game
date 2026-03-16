@props(['id', 'active' => false])

<div class="tab-content-language {{ $active ? 'active' : '' }}" data-tab="{{ $id }}">
  {{ $slot }}
</div>