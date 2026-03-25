@props([
  'name',
  'value' => null,
  'quantity' => 'single',
  'language' => 'es',
  'configuration' => ''
])

<div class="upload-image-container {{ $quantity }}"
  data-name="{{ $name }}"
  data-language="{{ $language }}"
  data-configuration="{{ $configuration }}"
  data-quantity="{{ $quantity }}"
>
  <button type="button" class="square-button">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"> <path d="M20,5A2,2 0 0,1 22,7V17A2,2 0 0,1 20,19H4C2.89,19 2,18.1 2,17V7C2,5.89 2.89,5 4,5H20M5,16H19L14.5,10L11,14.5L8.5,11.5L5,16Z" /></svg>
  </button>

  <div class="upload-image {{ $value ? '' : 'hidden' }}">
    <img
      src="{{ $value ? route('images_thumb', $value['filename']) : '' }}"
      alt="{{ $value['alt'] ?? '' }}"
      title="{{ $value['title'] ?? '' }}"
    >

    <button type="button" class="delete-button">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"> <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" /></svg>
    </button>
  </div>
</div>