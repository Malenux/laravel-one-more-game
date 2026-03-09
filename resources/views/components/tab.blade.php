@props(['id', 'active' => false])

<div class="tab-content {{ $active ? 'active' : '' }}" data-tab="{{ $id }}">
  {{ $slot }}
</div>