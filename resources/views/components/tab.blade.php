@props(['id'])

<div class="tab-content {{ $attributes->get('active') !== null ? 'active' : '' }}" data-tab="{{ $id }}">
  {{ $slot }}
</div>